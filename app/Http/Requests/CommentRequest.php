<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => 'required|string|max:2500',
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => '※コメントが入力されていません。',
            'comment.max' => '※コメントは2500文字以内で入力してください。',
        ];
    }

    public function attributes()
    {
        return [
            'comment' => 'コメント'
        ];
    }
}
