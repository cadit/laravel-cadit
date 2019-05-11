<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'user_id', 'title', 'image_url', 'goal_price', 'current_price'
    ];
}
