<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'user_id', 'card_no', 'card_brand', 'card_valid_month', 'card_valid_year', 'card_valid_cvc'
    ];

    static public function scopeStoreUserCard(array $data, array $result) {
        return self::create([
            'card_valid_month' => $data['exp_month'],
            'card_valid_year' => $data['exp_year'],
            'card_brand' => $data['brand'],
            'card_valid_cvc' => $result['card_valid_cvc'],
            'card_no' => $result['card_no'],
            'user_id' => Auth::user()->id
        ]);
    }
}
