<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Favourite extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'favouriteID';

    protected $fillable = [
        'favouriteID',
        'plannerID',
        'favouritePlannerID',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
