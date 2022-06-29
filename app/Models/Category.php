<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['user_type', 'title_ru', 'title_en'];

    public function subcategories(){
        return $this->hasMany(Subcategory::class);
    }
}
