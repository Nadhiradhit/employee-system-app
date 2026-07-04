<?php

namespace App\Http\Requests\Employee;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone_number' => ['required', 'string', 'max:20'],
            'department'   => ['required', 'string', 'max:50'],
            'joining_date' => ['required', 'date'],
            'status'       => ['required', 'in:active,inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone_number.required' => 'Phone number is required.',
            'phone_number.max'      => 'Phone number cannot exceed 20 characters.',
            'department.required'   => 'Department is required.',
            'department.max'        => 'Department cannot exceed 50 characters.',
            'joining_date.required' => 'Joining date is required.',
            'joining_date.date'     => 'Joining date must be a valid date.',
            'status.required'       => 'Status is required.',
            'status.in'             => 'Status must be active or inactive.',
        ];
    }
}
