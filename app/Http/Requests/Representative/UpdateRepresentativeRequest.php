<?php

namespace App\Http\Requests\Representative;

use App\Models\Representative;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRepresentativeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /**
         * Get representative to update from route
         */
        $representativeToUpdate = $this->route('representative');

        /**
         * Check if user can update the representative
         */
        if (request()->user()->can('update', $representativeToUpdate))
            return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /**
         * Get representative to update from route
         */
        $representativeToUpdate = $this->route('representative');

        return [
            'username' => 'required|string|max:255|unique:users,username,' . $representativeToUpdate->user->id,

            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:25',
        ];
    }
}
