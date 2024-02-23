@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="reserve_detail m-auto h-75">
    <p><span>{{$date}}日</span><span class="ml-3">{{$part}}部</span></p> <!--ルーティングで送られているパラメータ-->
    <div class="border detail_container">
      <table class="">
        <tr class="text-center detail_item">
          <th class="w-30">ID</th>
          <th class="w-50">名前</th>
          <th class="w-50">場所</th>
        </tr>
        @foreach($reservePersons as $person) <!--予約と関連するユーザーの情報-->
        @foreach($person->users as $user) <!--上記の中から更にユーザーの情報のみを取り出してforeachさせる-->
        <tr class="text-center  detail_user">
          <td class="detail_td">{{ $user->id }}</td>
          <td class="detail_td">{{ $user->over_name }}{{ $user->under_name }}</td>
          <td class="detail_td">リモート</td>
        </tr>
        @endforeach
        @endforeach
      </table>
    </div>
  </div>
</div>
@endsection
