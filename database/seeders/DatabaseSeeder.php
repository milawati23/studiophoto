<?php

namespace Database\Seeders;

use App\Models\Category; 
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['nama_kategori' => 'Prewedding']);
        Category::create(['nama_kategori' => 'Wisuda / Kelulusan']);
        Category::create(['nama_kategori' => 'Foto Keluarga']);
        Category::create(['nama_kategori' => 'Pas Foto / Reguler']);
    }
}