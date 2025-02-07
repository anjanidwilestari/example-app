<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Book extends Model implements Auditable
{
    // Mengaktifkan penggunaan trait HasFactory
    use HasFactory;

    use \OwenIt\Auditing\Auditable;

    // Menentukan nama tabel yang akan digunakan oleh model ini
    protected $table = 'books'; // Jika nama tabel sesuai dengan nama model, ini bisa dihilangkan

    // Menentukan kolom mana saja yang dapat diisi mass-assignment (bulk assignment)
    protected $fillable = [
        'title', 
        'author', 
        'description',
        'image',
        'video',
        'audio'
    ];
}
