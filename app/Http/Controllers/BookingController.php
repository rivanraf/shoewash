<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service; 
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Midtrans\Config;
use Midtrans\Snap;

class BookingController extends Controller
{
    public function index()
    {
        // Hanya tampilkan layanan yang is_active = true
        $services = Service::where('is_active', true)->get();
        return view('booking.index', compact('services'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'phone' => 'required',
            'shoe_type' => 'required',
            'service' => 'required',
            'shoe_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cek Kuota Tambahan (Safety Check)
        $quota = self::getQuotaStatus();
        if ($quota['is_full']) {
            return redirect()->back()->with('error', 'Maaf, kuota minggu ini sudah penuh!');
        }

        try {
            // 2. Logic Harga
            $serviceData = Service::find($request->service);
            $totalPrice = $serviceData ? $serviceData->price : 50000;

            // 3. Handle Upload Gambar (DILARANG DIUBAH)
            $imageName = null;
            if ($request->hasFile('shoe_image')) {
                $file = $request->file('shoe_image');
                $imageName = time() . '_' . Auth::id() . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('app/public/bookings'), $imageName);
            }

            // 4. Inisialisasi Nomor Order
            $orderNumber = 'SW-' . strtoupper(Str::random(8));

            // 5. Logika Expired Dinamis
            $expiredTime = ($request->pickup_method === 'midtrans') ? now()->addMinutes(15) : now()->addMinutes(5);

            // 6. Simpan ke Tabel Bookings
            $booking = Booking::create([
                'user_id'        => Auth::id(),
                'order_number'   => $orderNumber,
                'customer_name'  => Auth::user()?->name ?? 'Guest',
                'customer_phone' => $request->phone,
                'service_id'     => $request->service,
                'shoe_brand'     => $request->shoe_type,
                'shoe_image'     => $imageName,
                'total_price'    => $totalPrice,
                'payment_status' => 'pending',
                'status'         => 'pending',
                'payment_method' => $request->pickup_method,
                'expired_at'     => $expiredTime, // Menggunakan waktu dinamis
            ]);

            // 7. LOGIKA MIDTRANS
            if ($request->pickup_method === 'midtrans') {
                try {
                    Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
                    Config::$isProduction = (bool) filter_var(
                        env('MIDTRANS_IS_PRODUCTION', 'false'),
                        FILTER_VALIDATE_BOOLEAN
                    );
                    Config::$isSanitized  = true;
                    Config::$is3ds        = true;

                    $params = [
                        'transaction_details' => [
                            'order_id'     => $orderNumber,
                            'gross_amount' => (int) $totalPrice,
                        ],
                        'customer_details' => [
                            'first_name' => Auth::user()->name,
                            'phone'      => $request->phone,
                        ],
                    ];

                    $snapToken = Snap::getSnapToken($params);
                    $booking->update(['snap_token' => $snapToken]);

                } catch (\Exception $midtransError) {
                    Log::error('[Midtrans] Gagal mendapatkan Snap Token', [
                        'order_number' => $orderNumber,
                        'error'        => $midtransError->getMessage(),
                    ]);

                    return redirect()->route('booking.history')
                        ->with('success', 'Booking berhasil dibuat.')
                        ->with('warning', 'Gagal menghubungi gateway pembayaran. Silakan coba bayar ulang dari halaman riwayat.');
                }
            }

            return redirect()->route('booking.history')
                ->with('success', 'Booking berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan booking: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Fungsi Baru: Hapus Riwayat Expired
    public function destroy($id)
    {
        try {
            $booking = Booking::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

            // Proteksi: Hanya bisa hapus jika expired ATAU masih pending (untuk kebersihan dashboard)
            if ($booking->payment_status === 'pending' || $booking->expired_at->isPast()) {
                $booking->delete();
                return redirect()->back()->with('success', 'Riwayat booking berhasil dihapus.');
            }

            return redirect()->back()->with('error', 'Pesanan yang sedang diproses tidak bisa dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    public function history()
    {
        $bookings = Booking::with('service')
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->get();

        return view('booking.history', compact('bookings'));
    }

   public function showReceipt($order_number)
{
    $booking = Booking::with('service')
                ->where('order_number', $order_number)
                ->firstOrFail();

    // Proteksi Dasar
    $isAdmin = auth()->user()->role === 'admin' || auth()->user()->is_admin === true;
    if (!$isAdmin && $booking->user_id !== auth()->id()) {
        abort(403);
    }

    // LOGIKA STRATEGIS:
    // Jika Admin yang klik, kasih lihat halaman Detail
    if ($isAdmin) {
        return view('admin.booking-detail', compact('booking'));
    }

    // Jika Customer yang klik, kasih lihat halaman Struk biasa
    return view('booking.receipt', compact('booking'));
}

    public function track($order_number)
    {
        $booking = Booking::with('service') 
                    ->where('order_number', $order_number)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();

        return view('booking.track', compact('booking'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,washing,ready,success'
        ]);

        try {
            $booking = Booking::findOrFail($id);
            $booking->update([
                'status' => $request->status
            ]);

            return redirect()->back()->with('success', 'Status pesanan #' . $booking->order_number . ' berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update status: ' . $e->getMessage());
        }
    }

    public static function getQuotaStatus()
    {
        $maxQuota = \DB::table('settings')->where('key', 'weekly_quota')->value('value') ?? 6;

        $currentOrders = \App\Models\Booking::whereBetween('created_at', [
            now()->startOfWeek(), 
            now()->endOfWeek()
        ])->count();

        return [
            'is_full' => $currentOrders >= $maxQuota,
            'current' => $currentOrders,
            'max' => $maxQuota,
            'remaining' => $maxQuota - $currentOrders
        ];
    }

    public function callback(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $booking = Booking::where('order_number', $request->order_id)->first();
                if ($booking) {
                    $booking->update(['payment_status' => 'success']);
                }
            }
        }
        return response()->json(['status' => 'ok']);
    }
}