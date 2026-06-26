<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['nama_pelangan', 'no_hp', 'alamat'];
}