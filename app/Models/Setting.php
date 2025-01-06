<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'selected_book_id', 'selected_testimoni_ids', 'selected_reason_ids'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'selected_book_id');
    }

    public function selectedTestimonis()
    {
        return Testimoni::whereIn('id', json_decode($this->selected_testimoni_ids, true))->get();
    }

    public function selectedReasons()
    {
        return Reason::whereIn('id', json_decode($this->selected_reason_ids, true))->get();
    }

}
