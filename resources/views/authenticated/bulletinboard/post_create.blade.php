<!--投稿画面-->

@extends('layouts.sidebar')

@section('content')
<!--投稿フォーム-->
<div class="post_create_container d-flex">
  <div class="post_create_area border w-50 m-5 p-5">
    <form action="{{ route('post.create') }}" method="post" id="postCreate">
      {{ csrf_field() }}
      <div class="">
        <p class="mb-0">カテゴリー</p>
        <select class="w-100" form="postCreate" name="post_category_id">
          @foreach($main_categories as $main_category)
          <optgroup label="{{ $main_category->main_category }}"></optgroup> <!--optgroupはselect要素の選択グループを作成する、選択できない-->
          <!-- サブカテゴリー表示 -->
          @foreach($sub_categories as $sub_category)
          @if($main_category->id == $sub_category->main_category_id) <!--メインカテゴリーのidとサブカテゴリーのmain_category_idカラムの値が同じものを表示-->
          <option value="{{$sub_category->id}}">{{$sub_category->sub_category}}</option>
          @endif
          @endforeach
          @endforeach
        </select>
      </div>
      <div class="mt-3">
        @if($errors->first('post_title'))
        <span class="error_message">{{ $errors->first('post_title') }}</span>
        @endif
        <p class="mb-0">タイトル</p>
        <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
      </div>
      <div class="mt-3">
        @if($errors->first('post_body'))
        <span class="error_message">{{ $errors->first('post_body') }}</span>
        @endif
        <p class="mb-0">投稿内容</p>
        <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
      </div>
      <div class="mt-3 text-right">
        <input type="submit" class="btn btn-primary" value="投稿" form="postCreate">
      </div>
    </form>
  </div>

  <!--カテゴリー追加-->
  @can('admin') <!--管理者(講師アカウント)のみに見える内容-->
  <div class="w-25 ml-auto mr-auto">
    <div class="category_area mt-5 p-5">
      <!--メインカテゴリー追加-->
      <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">
        {{ csrf_field() }}
        <div class="">
          @if($errors->first('main_category_name'))
          <span class="error_message">{{ $errors->first('main_category_name') }}</span>
          @endif
          <p class="m-0">メインカテゴリー</p>
          <input type="text" class="w-100" name="main_category_name" form="mainCategoryRequest">
          <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="mainCategoryRequest">
      </form>
    </div>
    <!-- サブカテゴリー追加 -->
    <form action="{{ route('sub.category.create') }}" method="post" id="subCategoryRequest">
      {{ csrf_field() }}
      <div class="">
        <p class="m-0">サブカテゴリー</p>
        @if($errors->first('main_category_id'))
        <span class="error_message">{{ $errors->first('sub_category_id') }}</span>
        @endif
        @if($errors->first('sub_category_name'))
        <span class="error_message">{{ $errors->first('sub_category_name') }}</span>
        @endif
        <!--メインカテゴリーを選択するプルダウンをここに作る-->
        <select name="main_category_id" class="w-100" form="subCategoryRequest">
          <option>---</option>
          @foreach($main_categories as $main_category)
          <option value="{{$main_category->id}}"> <!--sub_categoryのmain_category_idカラムに保存されるidを取得するためセレクトボックスの値をmain_categoryのidにする-->
            {{$main_category->main_category}}
          </option>
          @endforeach
          <input type="text" class="w-100" name="sub_category_name" form="subCategoryRequest">
          <input type="submit" value="追加" class="w-100 btn btn-primary p-0" form="subCategoryRequest">
        </select>
    </form>
  </div>
</div>
</div>
@endcan
</div>
@endsection
