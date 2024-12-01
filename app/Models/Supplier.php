<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',   
        'phone',  
        'address',
        'comment', 
        'supplier_name'
        
    ];

    // Anda juga bisa menambahkan relasi jika diperlukan
    // Contoh relasi dengan produk:
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
