<?php

namespace App\Calendars\General;

use Carbon\Carbon;

class CalendarWeek
{
  protected $carbon;
  protected $index = 0;

  function __construct($date, $index = 0)
  {
    $this->carbon = new Carbon($date);
    $this->index = $index;
  }

  function getClassName()
  {
    return "week-" . $this->index;
  }

  /**
   * @return
   */

  function getDays()
  {
    $days = [];

    $startDay = $this->carbon->copy()->startOfWeek(); //週の初めの日付を取得
    $lastDay = $this->carbon->copy()->endOfWeek(); //週の終わりの日付を取得
    $tmpDay = $startDay->copy(); //月の最初の日を取得
    while ($tmpDay->lte($lastDay)) { //月曜日から日曜日までループさせる
      if ($tmpDay->month != $this->carbon->month) { //取得した日の月が今月ではない場合は空白(ブランク)
        $day = new CalendarWeekBlankDay($tmpDay->copy());
        $days[] = $day;
        $tmpDay->addDay(1);
        continue;
      }
      $day = new CalendarWeekDay($tmpDay->copy());
      $days[] = $day;

      $tmpDay->addDay(1);
    }
    return $days;
  }
}
