<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
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
            'title' => 'required|string',
            'type_id' => 'required|exists:type_tasks,id',
            'deadline' => 'nullable|date|after:today',
            'description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required.',
            'title.string' => 'Title must be a string.',
            'type_id.required' => 'Job type is required.',
            'type_id.exists' => 'Invalid job type.',
            'deadline.date' => 'Deadline must be a valid date.',
            'deadline.after' => 'Deadline must be after the current date.',
            'description.string' => 'Description must be a string.',
        ];
    }


}
