<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'selected_book_id', 'selected_testimoni_ids'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'selected_book_id');
    }

    // Relasi ke Testimoni
    public function selectedTestimonis()
    {
        return $this->hasManyThrough(Testimoni::class, User::class, 'user_id', 'id', 'user_id', 'selected_testimoni_ids');
    }
}
