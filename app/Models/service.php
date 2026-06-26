<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model {
    use HasFactory;
    protected $fillable = ['nama_layanan', 'kategori_id', 'harga', 'deskripsi'];

    // Hubungan ke tabel kategori
    public function category() {
        return $this->belongsTo(Category::class, 'kategori_id');
    }
}