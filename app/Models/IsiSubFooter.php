<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsiSubFooter extends Model
{
    use HasFactory;

    protected $fillable = ['sub_footer_id', 'name', 'link'];

    public function subFooter()
    {
        return $this->belongsTo(SubFooter::class);
    }
}
