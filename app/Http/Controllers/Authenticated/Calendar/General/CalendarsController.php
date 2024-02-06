<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
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

    public function reserve(Request $request)
    {
        DB::beginTransaction();
        try {
            $getPart = $request->getPart;
            $getDate = $request->getData;
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach ($reserveDays as $key => $value) {
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    public function delete(Request $request)
    {
        $delete = $request->delete_date;
        //detachで中間テーブルの紐付けを解除する記述を書く
        //
        $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part; //setting_partカラムを取得
        //未来の参加する日を表示
        if ($reservePart == 1) { //1なら
            $reservePart = "リモ1部";
        } else if ($reservePart == 2) { //2なら
            $reservePart = "リモ2部";
        } else if ($reservePart == 3) { //3なら
            $reservePart = "リモ3部";
        }
        return redirect()->route('calendar.general.show', compact('delete', 'reservePart'));
    }
}
