<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Users\Subject;



class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() //アクセスに対してフォームリクエストの利用が必要かを定義(真偽値)
    {
        return true; //trueにしておくことで権限拒否されない
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() //バリデーションルールを連想配列で記述
    {
        return [
            //記述方法：['検証する値'=>'検証ルール1 | 検証ルール2',]
            // もしくは、['検証する値'=>['検証ルール1', '検証ルール2'],]
            'over_name' => 'required|string|max:10', //必須|文字列|10文字以下
            'under_name' => 'required|string|max:10', //必須|文字列|10文字以下
            'over_name_kana' => 'required|string|max:30|/\A[ァ-ヴー]+\z/u', //必須|文字列|全角カタカナ|30文字以下
            'under_name_kana' => 'required|string|max:30|/\A[ァ-ヴー]+\z/u', //必須|文字列|全角カタカナ|30文字以下
            'mail_address' => ['required', 'string', 'email', 'max:100', Rule::unique('users')->ignore(Auth::id())],
            'sex' => 'required|', //必須
            'old_year' => 'required|date|after_or_equal:2000/1/1', //必須|日付かどうか|指定日と一致もしくは後かどうか
            'old_month' => 'required|date|after_or_equal:2000/1/1', //必須|日付かどうか|指定日と一致もしくは後かどうか
            'old_day' => 'required|date|after_or_equal:2000/1/1', //必須|日付かどうか|指定日と一致もしくは後かどうか
            'role' => 'required', //必須
            'password' => 'required|min:8|max:30|confirmed' //必須|8文字以上30文字以下|確認用と同じかどうか
        ];
    }

    public function messages()
    {
        return [
            //記述方法：検証する値.検証ルール=>'メッセージ',
            //検証ルールごとに設定が必要
            'over_name.required' => '姓は必須項目です。',
            'over_name.max:10' => '10文字以内で入力してください。',

            'under_name.required' => '名は必須項目です。',
            'under_name.max:10' => '10文字以内で入力してください。',

            'over_name_kana.required' => 'セイは必須項目です。',
            'over_name_kana.min:30' => '30文字以内で入力してください。',
            'over_name_kana./\A[ァ-ヴー]+\z/u' => 'カタカナで入力してください。',

            'under_name_kana.required' => 'メイは必須項目です。',
            'under_name_kana.min:30' => '30文字以内で入力してください。',
            'under_name_kana./\A[ァ-ヴー]+\z/u' => 'カタカナで入力してください。',

        ];
    }
}
