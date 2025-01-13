<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactElitech extends Model
{
    use HasFactory;

    protected $table = 'contact_elitechs';

    protected $fillable = [
        'whatsapp_number',
        'phone_number',
        'email',
        'instagram',
        'youtube',
        'address',
        'link_maps',
    ];
}
