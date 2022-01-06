<?php

namespace App\Http\Requests\Representative;

use App\Models\Representative;
use Illuminate\Foundation\Http\FormRequest;

class StoreRepresentativeRequest extends FormRequest
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
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|min:8|confirmed',

            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:25',
        ];
    }
}
