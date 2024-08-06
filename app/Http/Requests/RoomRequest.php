<?php

namespace App\Http\Requests;

use App\Rules\FileTypeValidate;
use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
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
    public function rules()
    {
        $rules =
         [
            'title' => 'required|string',
            'number' => 'required|string',
            'type' => 'required|in:room,bed',
            'ac_type' => 'required|in:ac,non_ac',
            'rooms_or_beds' => 'required|numeric',
            'rent_per_day' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'image' => ['required','image', new FileTypeValidate(['jpg','jpeg','png','JPG','JPEG','PNG']), 'max:3072'],
        ];
        if($this->method() == "PUT" && request()->old_room_image){
            $rules['image'] = ['nullable','max:3072','image', new FileTypeValidate(['jpg','jpeg','png','JPG','JPEG','PNG'])];
        }
        
        return $rules;
    }
}
