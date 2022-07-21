<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'rank',
        'text',
        'isActive'
    ];

    public function user(){
        return User::find($this->user_id);
    }

    public function toUser(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
