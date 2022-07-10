<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubcategoryUser extends Model
{
    use HasFactory;
    protected $fillable = ['subcategory_id', 'user_id'];
//    protected $table = 'subcategory_users';
}
