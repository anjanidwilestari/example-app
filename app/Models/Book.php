<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // Mengaktifkan penggunaan trait HasFactory
    use HasFactory;

    // Menentukan nama tabel yang akan digunakan oleh model ini
    protected $table = 'books'; // Jika nama tabel sesuai dengan nama model, ini bisa dihilangkan

    // Menentukan kolom mana saja yang dapat diisi mass-assignment (bulk assignment)
    protected $fillable = [
        'title', 
        'author', 
        'description'
    ];
}
