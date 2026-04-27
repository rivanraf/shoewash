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
            'description' => 'nullable',
        ]);

        $service = Service::findOrFail($id);
        
        // Ambil semua request, tambahkan is_active (karena checkbox tidak terkirim jika false)
        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        
        $service->update($data);
        
        return redirect()->back()->with('success', 'Layanan berhasil diupdate!');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        
        // Proteksi: Kita pastikan relasi aman dengan mengecek bookings()->exists()
        // Namun, kita ubah fungsinya menjadi Toggle Status (Soft Deactivate) agar data booking lama tidak error.
        $service->is_active = !$service->is_active;
        $service->save();

        $status = $service->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Layanan berhasil {$status}!");
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