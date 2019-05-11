<?php
/**
 * Created by PhpStorm.
 * User: solaris
 * Date: 2019-05-11
 * Time: 16:47
 */

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class BankService
{
    /**
     * @param string $password
     * @return float|int|string
     */
    public function accountDecryptPasswordSalt(string $password) {
        return $password * 100000 + (Auth::User()->phone % 102);
    }

    /**
     * @param string $password
     * @return float|int|string
     */
    public function accountEncryptPasswordSalt(string $password) {
        return $password % 100000 * 2;
    }
}
