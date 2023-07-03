<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassRequest extends FormRequest
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
        return [
//            'List_Classes.*.Name_class' => 'required|unique:classrooms,Name->ar,'.$this->id,
//            'List_Classes.*.Name_class_en' => 'required|unique:classrooms,Name->en,'.$this->id,

            'List_Classes.*.Name_class' => 'required',
            'List_Classes.*.Name_class_en' => 'required',

        ];
    }


    public function messages()
    {
        return [
            'Name_class.request'=>trans('validation.required'),
            'Name.unique' => trans('validation.unique'),
            'Name_class_en.request'=>trans('validation.required'),
            'Name_class_en.unique' => trans('validation.unique'),
        ];
    }
}
