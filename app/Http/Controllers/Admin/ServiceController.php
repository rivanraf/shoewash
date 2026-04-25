<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->get();
        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable'
        ]);

        Service::create($request->all());
        return redirect()->back()->with('success', 'Layanan baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $service = Service::findOrFail($id);
        $service->update($request->all());
        return redirect()->back()->with('success', 'Layanan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        
        // Proteksi: Jangan hapus jika ada booking yang pakai layanan ini
        if ($service->bookings()->exists()) {
            return redirect()->back()->with('error', 'Gagal hapus! Layanan ini masih digunakan dalam transaksi.');
        }

        $service->delete();
        return redirect()->back()->with('success', 'Layanan berhasil dihapus!');
    }

    public function updateQuota(Request $request)
    {
        \DB::table('settings')->updateOrInsert(
            ['key' => 'weekly_quota'],
            ['value' => $request->weekly_quota, 'updated_at' => now()]
        );
        return redirect()->back()->with('success', 'Kuota mingguan berhasil diperbarui!');
    }
}