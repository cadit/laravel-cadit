<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'deposit_id', 'inout_type', 'transaction_type', 'meno', 'amount', 'branch_name'
    ];
}
