<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
            'post_title' => 'required|string|max:100',
            'post_body' => 'required|string|max:5000',
        ];
    }

    public function messages()
    {
        return [
            'post_title.required' => '※タイトルは必須項目です。',
            'post_title.max' => '※タイトルは100文字以内で入力してください。',

            'post_body.required' => '※投稿内容は必須項目です。',
            'post_body.max' => '※投稿内容は1000文字以内で入力してください。',
        ];
    }

    public function attributes()
    {
        return [
            'post_title' => 'タイトル',
            'post_body' => '投稿内容',
        ];
    }
}
