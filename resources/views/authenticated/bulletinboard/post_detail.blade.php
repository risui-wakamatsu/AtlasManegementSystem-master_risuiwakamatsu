<!--投稿詳細画面-->

@extends('layouts.sidebar')
@section('content')
<div class="vh-100 d-flex">
  <div class="w-50 mt-5">
    <div class="m-3 detail_container" style="border-radius:5px">
      <div class="p-3">
        <div class="detail_inner_head">
          <div>
            @foreach($sub_categories as $sub_category)
            @if($post->subCategories->contains('id', $sub_category->id)) <!--$postに関するサブカテゴリーの情報が中間テーブルに入っているかチェックし、入っていれば対象のサブカテゴリーを表示する-->
            <p class="post_user_category btn-info" style="border-radius:5px;">{{$sub_category->sub_category}}</p>
            @endif
            @endforeach
          </div>
          @if(Auth::user()->id==$post->user_id) <!--idとuser_idがあっている時(自分の投稿)のみ編集と削除の機能が使える-->
          <div class="detail_btn">
            <span class="edit-modal-open btn btn-primary" post_title="{{ $post->post_title }}" post_body="{{ $post->post }}" post_id="{{ $post->id }}">編集</span>
            <a class="btn btn-danger" href="{{ route('post.delete', ['id' => $post->id]) }}" onclick="return confirm('この投稿を削除してよろしいでしょうか？')">削除</a>
          </div>
          @endif
        </div>

        <div class="contributor d-flex">
          <p>
            <span>{{ $post->user->over_name }}</span>
            <span>{{ $post->user->under_name }}</span>
            さん
          </p>
          <span class="ml-5">{{ $post->created_at }}</span>
        </div>
        <div class="detsail_post_title">{{ $post->post_title }}</div>
        @error('post_title')
        <strong class="error_message">{{ $message }}</strong> <!--投稿タイトルのエラーメッセージ-->
        @enderror
        <div class="mt-3 detsail_post">{{ $post->post }}</div>
        @error('post_body')
        <strong class="error_message">{{ $message }}</strong> <!--投稿内容のエラーメッセージ-->
        @enderror
      </div>
      <div class="p-3">
        <div class="comment_container">
          <span class="">コメント</span>
          @foreach($post->postComments as $comment)
          <div class="comment_area border-top">
            <p>
              <span>{{ $comment->commentUser($comment->user_id)->over_name }}</span>
              <span>{{ $comment->commentUser($comment->user_id)->under_name }}</span>さん
            </p>
            <p>{{ $comment->comment }}</p>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  <div class="w-50 p-3">
    <div class="comment_container border m-5" style="border-radius:5px">
      <div class="comment_area p-3">
        @if($errors->first('comment'))
        <span class="error_message">{{ $errors->first('comment') }}</span>
        @endif
        <p class="m-0">コメントする</p>
        <textarea class="w-100" name="comment" form="commentRequest"></textarea>
        <input type="hidden" name="post_id" form="commentRequest" value="{{ $post->id }}">
        <div class="comment_post_btn">
          <input type="submit" class="btn btn-primary" form="commentRequest" value="投稿">
        </div>
        <form action="{{ route('comment.create') }}" method="post" id="commentRequest">{{ csrf_field() }}</form>
      </div>
    </div>
  </div>
</div>
<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <form action="{{ route('post.edit') }}" method="post">
      <div class="w-100">
        <div class="modal-inner-title w-50 m-auto">
          <input type="text" name="post_title" placeholder="タイトル" class="w-100">
        </div>
        <div class="modal-inner-body w-50 m-auto pt-3 pb-3">
          <textarea placeholder="投稿内容" name="post_body" class="w-100"></textarea>
        </div>
        <div class="w-50 m-auto edit-modal-btn d-flex">
          <a class="js-modal-close btn btn-danger d-inline-block" href="">閉じる</a>
          <input type="hidden" class="edit-modal-hidden" name="post_id" value="">
          <input type="submit" class="btn btn-primary d-block" value="編集">
        </div>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
</div>
@endsection
