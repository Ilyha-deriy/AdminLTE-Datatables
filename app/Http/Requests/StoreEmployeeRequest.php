<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:256|unique:employees,name,'.$this->route('id') ?? 0,
            'recruitment_date' => 'required|date',
            'phone_number' => 'required|phone:UA',
            'email' => 'required|email',
            'payment' => 'required|numeric',
            'position_id' => 'required|exists:positions,id',
            'image_path' => 'image|mimes:jpg,png|max:5000|dimensions:min_width=300,min_height=300',
            'head_id' => 'exists:employees,name|nullable'
        ];
    }
}
