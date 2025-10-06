<?php

namespace App\Http\Requests\Global;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ReviewRequest extends FormRequest
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
            "order_id"=>"required|exists:orders,id",
            "rating"=>"required|integer|between:1,5",
            "comment"=>"nullable|string|max:1000"
        ];

    }
    public function messages(): array{
        return [
            "order_id.required"=> "you should pass order_id",
            "order_id.exists"=> "order not found",
            "rating.required"=> "the rating filed is required",
            "rating.betwwen"=>"rate limit is 1 to 5"

        ];
    }
}
