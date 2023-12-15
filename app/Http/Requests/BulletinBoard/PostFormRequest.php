<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
    public function rules() //投稿機能のバリデーション
    {
        return [
            'post_category_id' => 'required',
            'post_title' => 'required|string|min:100',
            'post_body' => 'required|string|min:5000',
        ];
    }

    public function messages()
    {
        return [
            'post_category_id.required' => 'カテゴリーは',
            'post_title.required' => 'タイトルは必須項目です。',
            'post_title.min' => 'タイトルは100文字以内で入力してください。',
            //'post_title.max' => 'タイトルは50文字以内で入力してください。',
            'post_body.required' => '内容は必須項目です。',
            'post_body.min' => '内容は5000文字以内で入力してください。',
            //'post_body.max' => '最大文字数は500文字です。',
        ];
    }
}
