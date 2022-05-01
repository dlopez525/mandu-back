<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDivisionRequest extends FormRequest
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
            'name' => "required|unique:divisions,id,{$this->id}|min:3|max:45",
            'level' => 'required|integer|min:0',
            'number_collaborators' => 'required|integer|min:0',
            'ambassador_id' => 'required|integer|min:0|exists:ambassadors,id',
            'superior_division_id' => 'nullable|exists:ambassadors,id',
            'sub_divisions.*' => 'required|string',
        ];
    }
}
