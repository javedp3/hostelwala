<?php

namespace App\Http\Requests;

use App\Rules\FileTypeValidate;
use Illuminate\Foundation\Http\FormRequest;

class HostelRequest extends FormRequest
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
            'name' => 'required',
            'hostel_rules' => 'required',
            'description' => 'required',
            'facilities.*' => 'required|string',
            'images' => 'required|array',
            'location' => 'required',
            'icons.*' => 'required|string',
            'images.*' => ['max:3072','image', new FileTypeValidate(['jpg','jpeg','png','JPG','JPEG','PNG'])]
        ];
        if($this->method() == "PUT" && request()->old_hostel_images){
            $rules['images'] = 'nullable|array';
            $rules['images.*'] = ['max:3072','image', new FileTypeValidate(['jpg','jpeg','png','JPG','JPEG','PNG'])];
        }

        return $rules;
    }
}
