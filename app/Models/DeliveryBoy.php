<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryBoy extends Model
{
    protected $fillable = [
        'name','place','address','email','phone','post','pin','photo','password','status'
    ];

    protected $hidden = [
        'password'
    ];
}
