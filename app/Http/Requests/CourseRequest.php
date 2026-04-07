<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
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
        $courseId = $this->route('course')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('courses', 'slug')->ignore($courseId)->whereNull('deleted_at'),
            ],
            'price' => ['required', 'numeric', 'gt:0'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'image' => ['nullable', 'image', 'max:2048'],
        ];
    }
}
