<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreWorktimeRequest extends FormRequest
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
            'worker_id' => ['required', 'string', 'exists:workers,id'],
            'date_start' => ['required', 'date', 'before:date_end'],
            'date_end' => ['required', 'date', 'after:date_start'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors()));
    }

    public function messages()
    {
        return [
            'worker_id.exists' => 'Podane UUID pracownika nie istnieje w bazie danych.',
            'worker_id.required' => 'Pole worker_id jest wymagane.',
            'date_start.required' => 'Pole data rozpoczęcia jest wymagane.',
            'date_end.required' => 'Pole data zakończenia jest wymagane.',
            'date_start.before' => 'Data rozpoczęcia musi być wcześniejsza niż data zakończenia.',
            'date_end.after' => 'Data zakończenia musi być późniejsza niż data rozpoczęcia.',
        ];
    }
}
