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
     * DASHBOARD OPERASIONAL
     */
    public function index()
    {
        $allBookings = Booking::with(['user', 'service'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        $stats = [
            'total'   => $allBookings->total(),
            'pending' => Booking::where('payment_status', 'pending')->where('expired_at', '>', now())->count(),
            'expired' => Booking::where('payment_status', 'pending')->where('expired_at', '<=', now())->count(),
            'success' => Booking::where('payment_status', 'success')->count(),
        ];

        return view('admin.dashboard', compact('allBookings', 'stats'));
    }

    /**
     * HALAMAN LAPORAN KEUANGAN (REPORT)
     */
    public function report()
    {
        $report = [
            'total_revenue' => Booking::where('payment_status', 'success')->sum('total_price'),
            'monthly_revenue' => Booking::where('payment_status', 'success')
                                ->whereMonth('created_at', now()->month)
                                ->sum('total_price'),
            'yearly_revenue' => Booking::where('payment_status', 'success')
                                ->whereYear('created_at', now()->year)
                                ->sum('total_price'),
            'top_services' => Booking::select('service_id', DB::raw('count(*) as total'))
                                ->groupBy('service_id')
                                ->orderBy('total', 'desc')
                                ->with('service')
                                ->get(),
        ];

        $transactions = Booking::with(['user', 'service'])
                        ->where('payment_status', 'success')
                        ->orderBy('updated_at', 'desc')
                        ->paginate(15);

        return view('admin.report', compact('report', 'transactions'));
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