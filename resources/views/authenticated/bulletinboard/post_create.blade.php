<!--投稿画面-->

@extends('layouts.sidebar')

@section('content')
<div class="post_create_container d-flex">
  <div class="post_create_area border w-50 m-5 p-5">
    <div class="">
      <p class="mb-0">カテゴリー</p>
      <select class="w-100" form="postCreate" name="post_category_id">
        <!--form属性：関連するform要素のidを記述している-->
        @foreach($main_categories as $main_category)
        <optgroup label="{{ $main_category->main_category }}"></optgroup>
        <!-- サブカテゴリー表示 -->
        </optgroup>
        @endforeach
      </select>
    </div>
    <div class="mt-3">
      @if($errors->first('post_title'))
      <span class="error_message">{{ $errors->first('post_title') }}</span>
      @endif
      <p class="mb-0">タイトル</p>
      <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
      <!--form属性：関連するform要素のidを記述している-->
    </div>
    <div class="mt-3">
      @if($errors->first('post_body'))
      <span class="error_message">{{ $errors->first('post_body') }}</span>
      @endif
      <p class="mb-0">投稿内容</p>
      <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
      <!--form属性：関連するform要素のidを記述している-->
    </div>
    <div class="mt-3 text-right">
      <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
      <!--form属性：関連するform要素のidを記述している-->
    </div>
    <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
    <!--ここのid属性が投稿に関するinputのform属性に記述されている-->
  </div>
  @can('admin') <!--管理者(講師アカウント)のみに見える内容-->
  <div class="w-25 ml-auto mr-auto">
    <div class="category_area mt-5 p-5">
      <div class="">
        <p class="m-0">メインカテゴリー</p>
        <input type="text" class="w-100" name="main_category_name" form="mainCategoryRequest">
        <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="mainCategoryRequest">
      </div>
      <!-- サブカテゴリー追加 -->
      <div class="">
        <p class="m-0">サブカテゴリー</p>
        <!--メインカテゴリーを選択するプルダウンをここに作る-->
        <select name="main_category_id" class="w-100" form="mainCategoryRequest">
          <option>---</option>
          @foreach($main_categories as $main_category)
          <option>
            {{$main_category->main_category}}
          </option>
          @endforeach
          <input type="text" class="w-100" name="sub_category_name" form="subCategoryRequest"> <!--サブカテゴリーの内容に変更する-->
          <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="subCategoryRequest"> <!--サブカテゴリーの内容に変更する-->
        </select>

      </div>

      <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">{{ csrf_field() }}</form>
      <!--ここのid属性が投稿に関するinputのform属性に記述されている-->
      <form action="{{ route('sub.category.create') }}" method="post" id="subCategoryRequest">{{ csrf_field() }}</form>
      <!--ここのid属性が投稿に関するinputのform属性に記述されている-->
    </div>
  </div>
  @endcan
</div>
@endsection
