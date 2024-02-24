<!--投稿一覧画面-->

@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <!--<p class="w-75 m-auto"></p>-->
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p class="post_user_name"><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a class="post_user_title" href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p> <!--投稿詳細へ-->
      <div class="post_bottom_area d-flex">
        @foreach($sub_categories as $sub_category)
        @if($post->subCategories->contains('id', $sub_category->id)) <!--$postに関するサブカテゴリーの情報が中間テーブルに入っているかチェックし、入っていれば対象のサブカテゴリーを表示する-->
        <p class="post_user_category btn-info" style="border-radius:5px;">{{$sub_category->sub_category}}</p>
        @endif
        @endforeach
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
  <div class="other_area no-border w-25">
    <div class="no-border m-4">
      <div class="post_btn"><a href="{{ route('post.input') }}"><button type="button" class="btn btn-info container-fluid">投稿</button></a></div>
      <div class="post_search">
        <input type="text" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input class="btn btn-info" type="submit" value="検索" form="postSearchRequest">
      </div>
      <div style="margin-top:10px">
        <input type="submit" name="like_posts" class="like_post_btn btn btn-danger" value="いいねした投稿" form="postSearchRequest">
        <input type="submit" name="my_posts" class="my_post_btn btn btn-warning" value="自分の投稿" form="postSearchRequest">
      </div>
      <div class="search_slide">
        <p>カテゴリー検索</p>
        <ul>
          @foreach($categories as $category)
          <li class="main_categories category_conditions border-bottom" category_id="{{ $category->id }}" style="margin-bottom:15px">
            <span>{{ $category->main_category }}</span>
            <span class="arrow-icon"></span> <!-- 上向き矢印を追加 -->
            <ul class="category_conditions_inner" style="display:none;">
              @foreach($sub_categories as $sub_category)
              @if($category->id == $sub_category->main_category_id)
              <li>
                <div class="border-bottom" style="margin:15px 0 15px 10px">
                  <input type="submit" name="category_word" class="category_btn" value="{{$sub_category->sub_category}}" form="postSearchRequest">
                </div>
              </li>
              @endif
              @endforeach
            </ul>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection
