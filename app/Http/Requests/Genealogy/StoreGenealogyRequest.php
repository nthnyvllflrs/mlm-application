<?php

namespace App\Http\Requests\Genealogy;

use Illuminate\Foundation\Http\FormRequest;

class StoreGenealogyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       /**
         * Check if user can create representatives
         */
        if (request()->user()->can('create', Representative::class))
            return true;

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'representative_id' => 'required|exists:representatives,id',
            'type' => 'required|in:STANDARD',
            'referral_id' => 'required|exists:genealogies,id',
            'reference_id' => 'required|exists:genealogies,id',
            'reference_position' => 'required|in:LEFT,RIGHT',

            /**
             * Note: Must check referral and reference id for cross references,
             *      reference can be equal to referral or must be a child of referral,
             *      and must check if the reference position is available
             */
        ];
    }
}
