<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $fillable=['message','read_at','subject','user_id','reply'];
}
