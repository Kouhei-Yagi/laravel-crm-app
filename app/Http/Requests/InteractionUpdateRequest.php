<?php

namespace App\Http\Requests;

use App\Models\Interaction;
use Illuminate\Foundation\Http\FormRequest;

class InteractionUpdateRequest extends FormRequest
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
            'interacted_at' => 'required|date_format:Y-m-d\TH:i',
            'type' => 'required|in:' . implode(',', array_keys(Interaction::TYPE)),
            'content' => 'required|string|max:2000',
            'memo' => 'nullable|string|max:2000',
        ];
    }
}
