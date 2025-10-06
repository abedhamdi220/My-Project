<?php

namespace App\Http\Requests\Provider;


use App\Enums\StatusOrderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "status" => ["required", "in:pending,approved,rejected,completed", "string"],
        ];
    }
    public function messages(): array
    {
        return [
            "status.required"=>"status is required filed",
            "status.string"=>"status should be string",
            "invild.status"=> "plese chose vaild status like:pending,approved,rejected,completed",

        ];
    }
}
