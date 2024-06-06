<?php


namespace App\Http\Requests\Profile;


use Diver\Http\Requests\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    protected $failedMessage = "Profile couldn't be updated.";

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        Log::info('UpdateRequest@rules');
        return [
            'full_name' => [
                'required',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore(Auth::id()),
            ],
        ];
    }
}
