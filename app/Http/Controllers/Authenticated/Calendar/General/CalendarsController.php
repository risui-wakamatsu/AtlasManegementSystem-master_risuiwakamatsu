<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\Users\User;
use Auth;
use DB;

//カレンダー一般用

class CalendarsController extends Controller
{
    public function show() //カレンダー表示
    {
        $calendar = new CalendarView(time()); //time()を使うことで現在時刻を渡し、今月のカレンダーを表示
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request) //予約機能
    {
        DB::beginTransaction(); //データベースの操作を行う
        try {
            $getPart = $request->getPart; //選択されたプルダウンのパート
            $getDate = $request->getData; //パートが選択された日時
            $reserveDays = array_filter(array_combine($getDate, $getPart)); //$reserveDays=リクエストで送られてきたパートと日時の連想配列になっている
            //array_filter：配列の要素を条件に基づいてフィルタリングしたい新しい配列を返す
            //array_combine：2つの配列を使用して新しい連想配列を作る 第一引数がキー、第二引数が値
            foreach ($reserveDays as $key => $value) { //$getDateが$key、$getPartが$value
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                //→reserve_settingsテーブルのsetting_reserveカラムに選択された日付が入っている、setting_partカラムに選択されたパートの番号が入っているという条件
                $reserve_settings->decrement('limit_users');
                //→decrement：属性の減算をするメソッド、上記の条件が満たされたときにlimit_usersカラムが減算される
                $reserve_settings->users()->attach(Auth::id());
                //→上記の条件が満たされたときにリレーション先のusersテーブルのログインユーザーのidと紐付けを行う
            }
            DB::commit(); //全ての操作が成功したらコミットし変更を確定する
        } catch (\Exception $e) {
            DB::rollback(); //エラーが発生したらロールバックして変更を取り消す
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    public function delete(Request $request) //キャンセル機能
    {
        //dd($request);
        //$reserve_settings=ReserveSettings::;
        DB::beginTransaction(); //データベースの操作を行う
        try {
            //idを取得
            $cancel = $request->cancel_id;
            //dd($cancel);
            //$cancel_date = $request->delete_part; //valueに値を入れればnullではなくなる
            //dd($cancel_date);
            //$cancel_part = $request->cancel_part;
            //日付の値を受け取る
            //時間（パート）の値を受け取る
            //$reserveDays = array_filter(array($cancel_date, $cancel_part)); //$reserveDays=リクエストで送られてきたパートと日時の連想配列になっている
            //foreach ($reserveDays as $key => $value) {
            $reserve_settings = ReserveSettings::where('id', $cancel)->first();
            $reserve_settings->increment('limit_users');
            //→increment：属性の増加をするメソッド、上記の条件が満たされたときにlimit_usersカラムが増加される
            $reserve_settings->users()->detach(Auth::id());
            //→上記の条件が満たされたときにリレーション先のusersテーブルのログインユーザーのidとdetach(紐付け解除)を行う
            //}
            DB::commit(); //全ての操作が成功したらコミットし変更を確定する
        } catch (\Exception $e) {
            DB::rollback(); //エラーが発生したらロールバックして変更を取り消す
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }
}
