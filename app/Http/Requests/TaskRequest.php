<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Allow all users for now
    }

    public function rules(): array
    {
        return [
            'title' => 'required|max:10',
            'description' => 'required|max:255',
            'long_description' => 'nullable|max:1000'
        ];
    }
}
