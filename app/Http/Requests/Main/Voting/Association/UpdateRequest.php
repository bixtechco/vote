<?php

namespace App\Http\Requests\Main\Voting\Association;

use Illuminate\Validation\Rule;

class UpdateRequest extends StoreRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();


        return $rules;
    }
}
