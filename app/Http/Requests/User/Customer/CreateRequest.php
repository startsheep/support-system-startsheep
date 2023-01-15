<?php

namespace App\Http\Requests\User\Customer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CreateRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string',
            'project_id' => 'required|array|exists:projects,id',
        ];
    }

    public function attributes()
    {
        return [
            'project_id' => 'project'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'messages' => $validator->errors(),
        ], 400);

        throw new ValidationException($validator, $response);
    }
}
