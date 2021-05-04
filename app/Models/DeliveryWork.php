<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryWork extends Model
{
    protected $fillable=[
        'boy_id','order_id','status'
    ];
}
