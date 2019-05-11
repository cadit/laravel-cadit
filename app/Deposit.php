<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'user_id', 'goal_id', 'transaction_id', 'cost_price', 'price'
    ];

}
