<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryRequest extends FormRequest
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
            //記述方法：['検証する値'=>'検証ルール1 | 検証ルール2',]
            // もしくは、['検証する値'=>['検証ルール1', '検証ルール2'],]
            'main_category_name' => 'required|string|max:100|unique:main_categories,main_category',
            //'main_category_id' => 'required', //sometimes
        ];
    }

    public function messages()
    {
        return [
            //記述方法：検証する値.検証ルール=>'メッセージ',
            //検証ルールごとに設定が必要
            'main_category_name.required' => '※メインカテゴリーは必須項目です。',
            'main_category_name.min:100' => '※メインカテゴリーは100文字以内で入力してください。',
            'main_category_name.unique' => '※登録済みのメインカテゴリーです。',
        ];
    }
}
