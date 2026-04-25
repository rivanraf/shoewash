<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Service::insert([
            ['name' => 'Deep Clean Sneakers', 'price' => 50000, 'description' => 'Pencucian menyeluruh luar dan dalam.'],
            ['name' => 'Suede Treatment', 'price' => 65000, 'description' => 'Perawatan khusus untuk bahan suede.'],
            ['name' => 'Leather Care', 'price' => 75000, 'description' => 'Pencucian dan conditioning untuk sepatu kulit.'],
            ['name' => 'Unyellowing', 'price' => 60000, 'description' => 'Menghilangkan noda kuning pada midsole.'],
            ['name' => 'Repaint', 'price' => 150000, 'description' => 'Pengecatan ulang warna sepatu.'],
        ]);
    }
}
