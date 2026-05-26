<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // PENTING: Harus ada untuk enkripsi password
use Illuminate\Validation\Rules;     // PENTING: Harus ada untuk validasi password Laravel

class AdminController extends Controller
{
    /**
     * DASHBOARD OPERASIONAL (DENGAN INTEGRASI FITUR SEARCH)
     */
    public function index(Request $request)
    {
        // 1. Tangkap kata kunci pencarian dari input text Blade
        $search = $request->get('search');

        // 2. Inisialisasi kueri dasar beserta relasi tabelnya
        $query = Booking::with(['user', 'service']);

        // 3. Suntikkan Logika Filter Jika Admin Menggunakan Fitur Pencarian
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'LIKE', "%{$search}%")
                  ->orWhere('customer_name', 'LIKE', "%{$search}%")
                  ->orWhere('customer_phone', 'LIKE', "%{$search}%")
                  ->orWhere('shoe_brand', 'LIKE', "%{$search}%");
            });
        }

        // 4. Eksekusi data dengan urutan terbaru dan amankan struktur pagination awal Anda (10 data)
        $allBookings = $query->orderBy('created_at', 'desc')->paginate(10);

        // 5. Logika perhitungan statistik dipertahankan utuh agar ringkasan data di atas card tidak rusak/berubah
        $stats = [
            'total'   => Booking::count(), // Menggunakan count langsung agar total kumulatif keseluruhan tidak terpotong hasil search
            'pending' => Booking::where('payment_status', 'pending')->where('expired_at', '>', now())->count(),
            'expired' => Booking::where('payment_status', 'pending')->where('expired_at', '<=', now())->count(),
            'success' => Booking::where('payment_status', 'success')->count(),
        ];

        return view('admin.dashboard', compact('allBookings', 'stats', 'search'));
    }

    /**
     * HALAMAN LAPORAN KEUANGAN (REPORT)
     */
    public function report(\Illuminate\Http\Request $request)
    {
        // 1. Ambil input bulan dari filter dropdown, default ke bulan berjalan saat ini
        $selectedMonth = $request->get('month', date('m'));
        $selectedYear = date('Y'); // Mengunci data pada tahun berjalan

        // 2. Daftar nama bulan untuk looping di komponen dropdown Blade
        $months = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        $report = [
            'total_revenue' => Booking::where('payment_status', 'success')->sum('total_price'),
            
            // LOGIKA BARU: Nilai ini sekarang dinamis mengikuti dropdown bulan yang dipilih admin
            'monthly_revenue' => Booking::where('payment_status', 'success')
                                ->whereYear('created_at', $selectedYear)
                                ->whereMonth('created_at', $selectedMonth)
                                ->sum('total_price'),
                                
            'yearly_revenue' => Booking::where('payment_status', 'success')
                                ->whereYear('created_at', now()->year)
                                ->sum('total_price'),
                                
            'top_services' => Booking::select('service_id', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                                ->groupBy('service_id')
                                ->orderBy('total', 'desc')
                                ->with('service')
                                ->get(),
        ];

        $transactions = Booking::with(['user', 'service'])
                        ->where('payment_status', 'success')
                        ->orderBy('updated_at', 'desc')
                        ->paginate(15);

        // Menyertakan variabel tambahan ($months dan $selectedMonth) tanpa membuang variabel lama
        return view('admin.report', compact('report', 'transactions', 'months', 'selectedMonth'));
    }

    /**
     * UPDATE STATUS PESANAN (KONFIRMASI BAYAR)
     */
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        if ($booking->payment_status === 'pending' && $booking->expired_at->isPast()) {
            return back()->with('error', 'Gagal! Pesanan #' . $booking->order_number . ' sudah kedaluwarsa.');
        }

        $booking->update(['payment_status' => 'success']);

        return back()->with('success', 'Pembayaran pesanan #' . $booking->order_number . ' berhasil dikonfirmasi.');
    }

    /**
     * HAPUS PESANAN EXPIRED
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->payment_status === 'pending' && $booking->expired_at->isPast()) {
            $booking->delete();
            return back()->with('success', 'Pesanan expired telah dibersihkan.');
        }

        return back()->with('error', 'Hanya pesanan yang sudah expired yang dapat dihapus.');
    }

    /**
     * DAFTAR USER & STAFF
     */
    public function users()
    {
        $users = User::where('id', '!=', auth()->id())
                    ->orderBy('role', 'asc')
                    ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * PROMOSI USER JADI ADMIN
     */
    public function makeAdmin($id)
    {
        $user = User::findOrFail($id);
        $user->update(['role' => 'admin']);
    
        return back()->with('success', $user->name . ' sekarang menjadi Admin Toko.');
    }

    /**
     * TOGGLE STATUS (SUSPEND ADMIN)
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        
        // Logika: Jika admin di-suspend, jadi customer. Jika customer di-active, jadi admin.
        $newRole = ($user->role === 'admin') ? 'customer' : 'admin';
        $status = ($newRole === 'admin') ? 'diaktifkan sebagai Admin' : 'dinonaktifkan (Suspend)';
        
        $user->update(['role' => $newRole]);

        return back()->with('success', 'Akses ' . $user->name . ' berhasil ' . $status);
    }

    /**
     * INPUT ADMIN BARU SECARA MANUAL
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Sekarang aman karena import Hash sudah ada
            'role' => 'admin',
        ]);

        return back()->with('success', 'Admin baru berhasil didaftarkan.');
    }
}