<?php

namespace App\Http\Requests;

use App\Rules\FileTypeValidate;
use Illuminate\Foundation\Http\FormRequest;

class CommunityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        $rules =
            [
                'title' => 'required',
                'description' => 'required',
                'image' =>  ['required','image', new FileTypeValidate(['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])],
            ];

        if ($this->method() == "PUT") {
            $rules['image'] = ['max:3072', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])];
        }

        return $rules;
    }
}
