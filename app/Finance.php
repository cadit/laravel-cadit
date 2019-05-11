<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = [
        'user_id', 'bank_code', 'bank_name', 'account_order_name', 'account_type', 'account_status', 'account_order_birthday', 'bank_account_number', 'bank_account_password'
    ];
}
