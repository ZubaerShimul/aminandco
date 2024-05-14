<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          => 'required|max:255',
            'designation'   => 'required|max:255',
            'NID'           => 'required|max:255',
            'contact_no'    => 'required|max:255',
            'joining_date'  => 'required|date',
            'basic_salary'  => 'required|numeric'
        ];
    }
}
