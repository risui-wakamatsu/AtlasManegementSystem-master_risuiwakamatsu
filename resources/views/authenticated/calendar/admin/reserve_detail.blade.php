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
        <tr class="text-center">
          @foreach($reservePersons as $person) <!--予約と関連するユーザーの情報-->
          @foreach($person->users as $user) <!--上記の中から更にユーザーの情報のみを取り出してforeachさせる-->
          <td class="w-25">{{ $user->id }}</td>
          <td class="w-25">{{ $user->over_name }}{{ $user->under_name }}</td>
          @endforeach
          <td class="w-25">リモート</td>
          @endforeach
        </tr>
      </table>
    </div>
  </div>
</div>
@endsection
