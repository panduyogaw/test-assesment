<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'nullable|uuid|exists:users,id',
            'status' => ['required', Rule::in(['pending', 'in_progress', 'done'])],
            'due_date' => 'nullable|date|after_or_equal:today',
        ];
    }
}
