<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            "title"=>"required|string|min:2|max:20|unique:tasks,title", 
            "subject"=>"required|string|min:2|max:20", 
            "description"=>"required|string|min:2|max:1000", 
            "status"=>"required|in:pending,going,closed", 
            "user_id"=>"required|integer|exists:users,id"
        ];
    }
}
