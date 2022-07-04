<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $fillable = ['title_ru', 'title_en', 'key'];


    public function users(){
        return $this->belongsToMany(Language::class);
    }
}