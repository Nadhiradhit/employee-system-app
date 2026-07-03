<?php

namespace App\Http\Requests\Employee;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'phone_number' => 'required|string|max:15',
            'department' => 'required|string|max:100',
            'joining_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'User ID is required.',
            'user_id.exists' => 'User ID does not exist.',
            'phone_number.required' => 'Phone number is required.',
            'phone_number.max' => 'Phone number cannot exceed 15 characters.',
            'department.required' => 'Department is required.',
            'department.max' => 'Department cannot exceed 100 characters.',
            'joining_date.required' => 'Joining date is required.',
            'joining_date.date' => 'Joining date must be a date.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be active or inactive.',
        ];
    }
}
