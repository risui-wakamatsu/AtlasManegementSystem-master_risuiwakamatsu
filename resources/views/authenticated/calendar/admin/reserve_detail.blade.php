@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <p><span>{{$date}}日</span><span class="ml-3">{{$part}}部</span></p> <!--ルーティングで送られているパラメータ-->
    <div class="h-75 border">
      <table class="">
        <tr class="text-center">
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
          <th class="w-25">場所</th>
        </tr>
        @foreach($reservePersons as $person) <!--予約と関連するユーザーの情報-->
        @foreach($person->users as $user) <!--上記の中から更にユーザーの情報のみを取り出してforeachさせる-->
        <tr class="text-center ">
          <td class="">{{ $user->id }}</td>
          <td class="">{{ $user->over_name }}{{ $user->under_name }}</td>
          <td class="">リモート</td>
        </tr>
        @endforeach
        @endforeach
      </table>
    </div>
  </div>
</div>
@endsection
