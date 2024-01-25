<!--投稿一覧画面-->

@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p> <!--投稿詳細へ-->
      <div class="post_bottom_area d-flex">
        <p><span class="category_btn"></span></p> <!---サブカテゴリーが表示される記述をする　多分中間テーブル？-->
        <div class="d-flex post_status">
          <div class="mr-5">
            <!--コメント-->
            <i class="fa fa-comment"></i><span class="post_comment_counts{{$post->id}}">{{$post->postComments()->count()}}</span>
          </div>
          <div>
            <!--いいね機能-->
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{$like->likeCounts($post->id)}}</span></p> <!--黒ハート post->idがlikeテーブルにある数をカウント-->
            <!--$likeはPostsControllerでLikeモデルをインスタンスしたもの、Likeモデル内のlikeCountsメソッドをpost_idすなわちPostテーブルのidを引数に入れていいね数を表示させる-->
            @else
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{$like->likeCounts($post->id)}}</span></p> <!--赤ハート post->idがlikeテーブルにある数をカウント-->
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area border w-25">
    <div class="border m-4">
      <div class=""><a href="{{ route('post.input') }}">投稿</a></div>
      <div class="">
        <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" value="検索" form="postSearchRequest">
      </div>
      <input type="submit" name="like_posts" class="category_btn" value="いいねした投稿" form="postSearchRequest">
      <input type="submit" name="my_posts" class="category_btn" value="自分の投稿" form="postSearchRequest">
      <ul>
        @foreach($categories as $category)
        <li class="main_categories" category_id="{{ $category->id }}"><span>{{ $category->main_category }}<span></li>
        @foreach($sub_categories as $sub_category)
        @if($category->id == $sub_category->main_category_id) <!--メインカテゴリーのidとサブカテゴリーのmain_category_idカラムの値が同じものを表示-->
        <input type="submit" name="category_word" class="category_btn" value="{{$sub_category->sub_category}}" form="postSearchRequest">
        @endif
        @endforeach
        @endforeach
      </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection
