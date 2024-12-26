<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubFooter extends Model
{
    use HasFactory;

    protected $fillable = ['footer_id', 'name', 'link'];

    public function footer()
    {
        return $this->belongsTo(Footer::class);
    }
}
