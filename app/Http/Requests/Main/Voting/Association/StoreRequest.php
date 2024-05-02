<?php

namespace App\Http\Requests\Main\Voting\Association;

use Diver\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Failed Message
     *
     * @var string
     */
    protected $failedMessage = "Association couldn't be created.";

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => [
                'required' => 'required',
            ],

            'description' => [
                'required' => 'required',
            ],
        ];

        return $rules;
    }

}
