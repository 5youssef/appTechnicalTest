<?php

namespace App\Http\Requests\Project;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => ['exists:users,id'],
            'status_id' => ['required', 'exists:statuses,id'],
            'title' => ['required', 'string', 'max:255'],
            'deadline' => ['required', 'date'],
            'description' => ['nullable', 'string'],
        ];
    }
}
