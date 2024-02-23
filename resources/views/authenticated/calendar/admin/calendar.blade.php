<!--管理者　スクール予約確認画面-->

@extends('layouts.sidebar')

@section('content')
<div class="w-75 m-auto">
  <div class="w-100" style="background:#FFF;">
    <div class="border" style="padding:20px 40px; margin:30px 0; border-radius:5px;">
      <p style="text-align:center; margin-top:40px;">{{ $calendar->getTitle() }}</p>
      <p>{!! $calendar->render() !!}</p>
    </div>
  </div>
</div>
@endsection
