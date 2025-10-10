<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
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
                        'name' => ['sometimes','string','max:255'],
            'description' => ['nullable','string','sometimes'],
            'price' => ['nullable','numeric','min:0','sometimes'],
            'category_id' => ['sometimes','integer','exists:categories,id'],
            'status' => ['nullable','in:active,inactive'],
            'image'=> ['nullable','image','mimes:png,jpg,jpeg','max:2048','sometimes'],
        ];
    }
}
