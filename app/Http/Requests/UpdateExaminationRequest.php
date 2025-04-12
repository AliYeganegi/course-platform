<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExaminationRequest extends FormRequest
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
            'quiz_link' => 'required|url',
            'quiz_status' => 'required|in:active,inactive',
            'quiz_start_datetime' => 'nullable|date',
            'quiz_end_datetime' => 'nullable|date|after_or_equal:quiz_start_datetime',
            'quiz_number_of_attempts' => 'required|integer|min:1',
            'name' => 'nullable|string',
            'total_point' => 'nullable|decimal:0,2',
            'number_of_questions' => 'nullable|integer|min:1',
            'exam_duration' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}
