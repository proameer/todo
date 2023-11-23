<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoUpdateRequest extends FormRequest
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
            'todo_type_id' => 'required|exists:todo_types,id',
            'user_id' => 'required|integer|exists:users,id',
            'note' => 'required|string|max:50',
            'is_done' => 'nullable|boolean',
            'date_done' => 'nullable|date',
            // 'phone' => 'required|starts_with:07,+964,00964',
            // 'array_values' => 'nullable|array',
        ];
    }
}
