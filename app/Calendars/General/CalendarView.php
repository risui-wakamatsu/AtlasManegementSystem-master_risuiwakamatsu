<?php

namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView
{

  private $carbon;
  function __construct($date)
  {
    $this->carbon = new Carbon($date); //Carbon：日付を扱う時に利用可能なライブラリ
  }

  public function getTitle()
  { //タイトルを取得
    return $this->carbon->format('Y年n月');
  }

  function render()
  { //カレンダーを出力
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks(); //1ヶ月のカレンダー　このページの一番下のメソッド
    foreach ($weeks as $week) {
      $html[] = '<tr class="' . $week->getClassName() . '">';

      $days = $week->getDays(); //日付を取得
      foreach ($days as $day) {
        $startDay = $this->carbon->copy()->format("Y-m-01"); //1日
        $toDay = $this->carbon->copy()->format("Y-m-d"); //今日

        if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) { //1日より後もしくは1日も含む日付 かつ 今日よりも前もしくは今日を含む日付 グレーアウトする
          $html[] = '<td class="past-day calendar-td">'; //past-day→過去の日付
        } else {
          $html[] = '<td class="calendar-td ' . $day->getClassName() . '">';
        }
        $html[] = $day->render();

        //ここのif文使って受付終了、参加した部数の表示
        if (in_array($day->everyDay(), $day->authReserveDay())) { //in_array：配列が指定した値を含むかチェック 予約していた場合
          //everyDay()：日付フォーマット　authReserveDay()：reserveSettingsテーブルのsetting_reserveカラム
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part; //setting_partカラムを取得
          //未来の参加する日を表示
          if ($reservePart == 1) { //1なら
            $reservePart = "リモ1部";
          } else if ($reservePart == 2) { //2なら
            $reservePart = "リモ2部";
          } else if ($reservePart == 3) { //3なら
            $reservePart = "リモ3部";
          }
          if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) { //予約していた場合の、1日より後もしくは1日も含む日付 かつ 今日よりも前もしくは今日を含む日付なら(1日からき今日までの日付)
            $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part; //setting_partカラムを取得
            if ($reservePart == 1) { //1なら
              $reservePart = "1部";
            } else if ($reservePart == 2) { //2なら
              $reservePart = "2部";
            } else if ($reservePart == 3) { //3なら
              $reservePart = "3部";
            }
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">' . $reservePart . '参加</p>'; ///参加した部数を上記のif文で取得　変数をpタグに埋め込む
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          } else {
            $html[] = '<button type="submit" class="open-modal btn btn-danger p-0 w-75" name="delete_date" style="font-size:12px" value="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '" delete_date="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '" delete_part="' . $reservePart . '" cancel_id="' . $day->authReserveDate($day->everyDay())->first()->id . '">' . $reservePart . '</button>'; //キャンセルボタン
            //id=~~~で記述してしまうと一つのボタンしか反応しなくなってしまうので、モーダル機能のボタンはclass=~~~~で記述
            //delete_date属性とdelete_part属性を用いて値をjsに送信する
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }
        } else if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) { //else ifを追加する(予約していないけど過去日の場合)　予約していない場合の1日から今日までの日付
          $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">受付終了</p>';
          $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
        } else {
          $html[] = $day->selectPart($day->everyDay()); //枠がなかった時の予約用のプルダウンを取得 予約していなくて未来の日付
        }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">' . csrf_field() . '</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">' . csrf_field() . '</form>';

    return implode('', $html);
  }

  protected function getWeeks()
  {
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth(); //月の最初の日を取得
    $lastDay = $this->carbon->copy()->lastOfMonth(); //月の最後の日を取得
    $week = new CalendarWeek($firstDay->copy()); //CalendarWeekクラスから月の最初の日を取得
    $weeks[] = $week; //月の最初の日を配列に格納
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek(); //月の最初の日の7日後を取得　1週間になる
    while ($tmpDay->lte($lastDay)) {
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}
