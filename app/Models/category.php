<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Daftarkan kolom yang boleh diisi data secara massal
    protected $fillable = ['name', 'slug'];
}