<!--スクール予約画面-->

@extends('layouts.sidebar')

@section('content')
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">

      <p class="text-center">{{ $calendar->getTitle() }}</p> <!--CalendarViewクラスからgetTitleメソッドのタイトルを取得-->
      <div class="">
        {!! $calendar->render() !!} <!--CalendarViewクラスからrenderメソッドのカレンダーを取得-->
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
    </div>
  </div>
</div>

<!--modal-->
<div class="modal">
  <div class="modal__bg">
    <div class="modal__content">
      <form action="{{route('deleteParts')}}" method="post">
        <p>予約日：</p>
        <p>時間：</p>
        <p>上記の予約キャンセルしてもよろしいですか？</p>
        <a href="" class="js-modal-close btn btn-primary">閉じる</a>
        <a href="" class="btn btn-danger">キャンセル</a>
      </form>
    </div>
  </div>
</div>

@endsection
