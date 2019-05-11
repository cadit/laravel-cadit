<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verify extends Model
{
    const PHONE_UNVERIFY = 0;
    const PHONE_VERIFY = 1;

    protected $fillable = [
        'email', 'phone', 'verify'
    ];
}
