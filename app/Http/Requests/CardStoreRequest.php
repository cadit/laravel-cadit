<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardStoreRequest extends FormRequest
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
            'card_no' => 'required|string',
            'card_valid_month' => 'required',
            'card_valid_year' => 'required',
            'card_valid_cvc' => 'required',
        ];
    }
}
