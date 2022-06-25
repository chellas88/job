<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'country_id',
        'state',
        'city',
        'city_coordinates',
        'coordinates',
        'address',
        'password',
        'category_id',
        'lang',
        'google_id',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function contacts(){
        return $this->hasMany(Contact::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getRating(){
        $reviews = Review::where('user_id', $this->id)->get();
        $rank = 0;
        $count = 0;
        if (!$reviews->isEmpty()) {
            foreach ($reviews as $item) {
                $rank += intval($item['rank']);
                $count++;
            }
            return ($rank / $count);
        }
        else return 0;

    }
}
