<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            "customers_id" => "required|integer",
            "transaction_total" => "required|integer",
            "transaction_status"=> "nullable|string|in:PENDING,SUCCESS,FAILED",
            "transaction_details" => "required|array",
            "transaction_details.*" => "integer|exists:products,id",
        ];
    }
}
