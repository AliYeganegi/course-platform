<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreExaminationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        abort_if(Gate::denies('enrollment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'course_id' => 'required|exists:courses,id',
            'quiz_link' => 'required|url',
            'quiz_status' => 'required|in:active,inactive',
            'quiz_start_datetime' => 'nullable|date',
            'quiz_end_datetime' => 'nullable|date',
            'quiz_number_of_attempts' => 'required|integer|min:1',
            'name' => 'nullable|string',
            'total_point' => 'nullable|decimal:0,2',
            'number_of_questions' => 'nullable|integer|min:1',
            'exam_duration' => 'nullable|string',
            'description' => 'nullable|string'
        ];
    }
}
