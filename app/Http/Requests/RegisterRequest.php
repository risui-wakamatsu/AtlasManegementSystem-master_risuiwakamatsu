<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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

    //ユーザー登録画面のバリデーション
    public function rules() //バリデーションルールを連想配列で記述
    {
        return [
            //記述方法：['検証する値'=>'検証ルール1 | 検証ルール2',]
            // もしくは、['検証する値'=>['検証ルール1', '検証ルール2'],]
            'over_name' => 'required|string|max:10', //必須|文字列|10文字以下
            'under_name' => 'required|string|max:10', //必須|文字列|10文字以下
            'over_name_kana' => 'required|string|max:30|regex:/\A[ァ-ヴー]+\z/u', //必須|文字列|30文字以下|regex:→〇〇だけど:全角カタカナのみ
            'under_name_kana' => 'required|string|max:30|regex:/\A[ァ-ヴー]+\z/u', //必須|文字列|30文字以下|regex:→〇〇だけど:全角カタカナのみ
            'mail_address' => ['required', 'string', 'email', 'max:100', Rule::unique('users')->ignore(Auth::id())],
            'sex' => ['required', Rule::in(1, 2, 3)], //必須|許可する値を指定、valueで飛んでくるデータを許可するルール
            'birth_day' => 'required|date|after_or_equal:2000-1-1', //生年月日(old_year,old_month,old_day)をまとめたもの
            'old_year' => 'required_with:old_month,old_day', //必須
            'old_month' => 'required_with:old_year,old_day', //必須
            'old_day' => 'required_with:old_year,old_month', //必須
            'role' => ['required', Rule::in(1, 2, 3, 4)], //必須|許可する値を指定、valueで飛んでくるデータを許可するルール
            'password' => 'required|min:8|max:30|confirmed', //必須|8文字以上30文字以下|確認用と同じかどうか
            //'password_confirmation' => 'required|min:8|max:30',
            //confirmedのためにある項目だから不要
        ];
    }

    public function getValidatorInstance() //生年月日のバリデーションルールをカスタマイズ
    {
        $birthDate = implode('-', $this->only(['old_year', 'old_month', 'old_day']));
        $this->merge([
            'birth_day' => $birthDate,
        ]);
        return parent::getValidatorInstance();
    }

    public function messages()
    {
        return [
            //記述方法：検証する値.検証ルール=>'メッセージ',
            //検証ルールごとに設定が必要
            'over_name.required' => '※姓は必須項目です。',
            'over_name.max:10' => '※10文字以内で入力してください。',

            'under_name.required' => '※名は必須項目です。',
            'under_name.max:10' => '※10文字以内で入力してください。',

            'over_name_kana.required' => '※セイは必須項目です。',
            'over_name_kana.min:30' => '※セイは30文字以内で入力してください。',
            'over_name_kana.regex' => '※セイはカタカナで入力してください。',

            'under_name_kana.required' => '※メイは必須項目です。',
            'under_name_kana.min:30' => '※メイは30文字以内で入力してください。',
            'under_name_kana.regex' => '※メイはカタカナで入力してください。',

            'mail_address.required' => '※メールアドレスは必須項目です。',
            'mail_address.email' => '※正しいメール形式で入力してください。',
            'mail_address.max:100' => '※100文字以内で入力してください。',
            'mail_address.unique' => '※登録済みのメールアドレスです。',

            'sex.required' => '※性別は必須項目です。',

            'birth_day.required' => '※生年月日は必須項目です。',
            'birth_day.date' => '※生年月日は正しい日付を入力してください。',
            'birth_day.after_or_equal' => '※2000年1月1日以降の生年月日を入力してください。',
            'old_year.required' => '※年は必須項目です。',
            //'old_year.after_or_equal' => '※2000年以降の正しい年を入力してください。',
            'old_month.required' => '※月は必須項目です。',
            //'old_month.after_or_equal' => '※2000年1月1日以降の正しい日付を入力してください。',
            'old_day.required' => '※日は必須項目です。',
            //'old_day.after_or_equal' => '※2000年1月1日以降の正しい日付を入力してください。',

            'role.required' => '※役職は必須項目です。',

            'password.required' => '※パスワードは必須項目です。',
            'password.min:8' => '※パスワードは8文字以上で入力してください。',
            'password.max:30' => '※パスワードは30文字以下で入力してください。',
            'password.confirmed' => '※パスワードが一致していません。',
            //'password_confirmation.required' => '※確認用パスワードは必須項目です。',
            //'password_confirmation.min:8' => '※確認用パスワードは8文字以上で入力してください。',
            //'password_confirmation.max:30' => '※確認用パスワードは30文字以下で入力してください。',
        ];
    }

    //ここにattributesメソッドを追加しても英語を日本語に変換できる
}
