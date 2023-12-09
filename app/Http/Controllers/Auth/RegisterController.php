<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest; //クラスをuse宣言
use App\Models\Users\Subjects;

use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function registerView()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    public function registerPost(RegisterRequest $request) //登録が行われるだけのメソッド
    {
        DB::beginTransaction(); //トランザクション処理、データベース構造内でデータを修正するクエリ
        try {
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data));
            $subjects = $request->subject;

            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                //'sex' => $request->sex([1, 2, 3]), //データが送られる時にvalueの数字で認識する
                'birth_day' => $birth_day,
                'role' => $request->role,
                //'role' => $request->role([1, 2, 3, 4]), //データが送られる時にvalueの数字で認識する
                'password' => bcrypt($request->password)
            ]);
            $user = User::findOrFail($user_get->id); //findOrFail→引数に当するものを取り出して表示するメソッド、Usersテーブルから$user_getで登録された内容から$idを取り出す
            $user->subjects()->attach($subjects); //登録から取り出したidと->subjectsテーブルをリレーション(Userモデルのsubjects())→リクエストで飛んできた$subjectと紐付け(attach)する
            DB::commit(); //全ての処理が計画通りに行った時に使用
            return view('auth.login.login');
        } catch (\Exception $e) { //例外が起きた時↓
            DB::rollback(); //一部でも失敗があれば変更または操作を取り消す
            return redirect()->route('loginView');
        }
    }
}
