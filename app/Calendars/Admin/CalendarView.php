<?php

namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Users\User;

class CalendarView
{
  private $carbon;

  function __construct($date)
  {
    $this->carbon = new Carbon($date); //Carbon：日付を扱う時に利用可能なライブラリ
  }

  //日付を○年△月で取得
  public function getTitle() //タイトルを取得
  {
    return $this->carbon->format('Y年n月');
  }

  public function render() //カレンダーを出力
  {
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table m-auto border">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th class="border">月</th>';
    $html[] = '<th class="border">火</th>';
    $html[] = '<th class="border">水</th>';
    $html[] = '<th class="border">木</th>';
    $html[] = '<th class="border">金</th>';
    $html[] = '<th class="border">土</th>';
    $html[] = '<th class="border">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';

    $weeks = $this->getWeeks(); ///週カレンダーオブジェクトの配列を取得

    foreach ($weeks as $week) { //週カレンダーオブジェクトを繰り返す
      $html[] = '<tr class="' . $week->getClassName() . '">'; //クラス名を出力
      $days = $week->getDays(); //日カレンダーオブジェクトを取得
      foreach ($days as $day) { //日カレンダーオブジェクトを繰り返す
        $startDay = $this->carbon->format("Y-m-01"); //月の初日(1日)
        $toDay = $this->carbon->format("Y-m-d"); //今日
        if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) { //1日より後もしくは1日も含む日付 かつ 今日よりも前もしくは今日を含む日付
          $html[] = '<td class="past-day border">'; //past-day　過去の日付
        } else {
          $html[] = '<td class="border ' . $day->getClassName() . '">';
        }
        $html[] = $day->render();
        $html[] = $day->dayPartCounts($day->everyDay());
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';

    return implode("", $html);
  }

  protected function getWeeks()
  {
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while ($tmpDay->lte($lastDay)) {
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
