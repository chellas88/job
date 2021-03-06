<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'title_ru',
        'title_en'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

}
