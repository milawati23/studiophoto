<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
    use HasFactory;
    // Izinkan kolom-kolom ini diisi data (Sesuai ERD)
    protected $fillable = ['nama_pelanggan', 'no_hp', 'alamat']; 
}