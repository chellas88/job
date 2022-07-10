<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = ['phone', 'viber', 'telegram', 'whatsapp', 'facebook', 'instagram', 'user_id'];
}
