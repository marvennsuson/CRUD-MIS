<?php

namespace App;

use Illuminate\Foundation\Auth\Resident as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
class Resident extends Authenticatable
{
    use Notifiable;
    protected $guarded = [];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
