<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageUser extends Model
{
    use HasFactory;
    protected $fillable = ['language_id', 'user_id'];
    protected $table = 'language_user';
}
