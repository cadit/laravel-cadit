<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinanceFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bank_name' => 'required|string',
            'account_type' => 'required|integer',
            'account_order_name' => 'required|string',
            'account_order_birthday' => 'required|integer',
            'bank_account_number' => 'required|string',
            'bank_account_password' => 'required|integer|digits:2'
        ];
    }
}
