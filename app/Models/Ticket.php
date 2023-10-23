<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'ticekts';

    protected $pimaryKey = 'ticketKey';
    
    protected $fillable=[
        'ticketKey',
        'ticketType',
        'userToken',
    ];

    protected $hidden=[
        'ticketKey',
    ];
}
