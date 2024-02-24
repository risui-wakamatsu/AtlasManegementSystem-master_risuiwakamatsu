<!--スクール予約画面-->

@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-3" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto">
      <p class="text-center">{{ $calendar->getTitle() }}</p> <!--CalendarViewクラスからgetTitleメソッドのタイトルを取得-->
      <div class="reserve_calendar border" style="border-radius:5px;">
        {!! $calendar->render() !!} <!--CalendarViewクラスからrenderメソッドのカレンダーを取得-->
      </div>
    </div>
    <div class="text-right w-75 m-auto" style="padding-top:20px">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>

<!--キャンセルボタン　モーダル機能-->
<div class="modal">
  <div class="modal__bg">
    <div class="modal__content">
      <div style="margin-left:20%">
        <div class="modal_delete_date">
          <p></p> <!--js側でここに「予約日：」が入るように記述 pタグで表示-->
        </div>
        <div class="modal_delete_part">
          <p></p> <!--js側でここに「時間：」が入るように記述-->
        </div>
        <p>上記の予約キャンセルしてもよろしいですか？</p>
      </div>
      <div style="margin-left:20%">
        <a href="" class="js-modal-close btn btn-primary">閉じる</a>
        <input type="submit" class="btn btn-danger modal_cancel_btn" style="margin-left:50%" value="キャンセル" form="deleteParts"></input>
      </div>
      <input class="cancel_date_hidden" type="hidden" name="delete_part" value="" form="deleteParts"> <!--jsからデータを受け取りcontrollerへ送信する-->

      <input class="cancel_part_hidden" type="hidden" name="cancel_part" value="" form="deleteParts">
      <input class="cancel_id_hidden" type="hidden" name="cancel_id" value="" form="deleteParts"> <!--idを取得するためのフォーム-->
    </div>
  </div>
</div>

@endsection
