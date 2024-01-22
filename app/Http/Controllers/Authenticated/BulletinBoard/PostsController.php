<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; //通常のリクエストインスタンスの読み込み
use App\Models\Categories\MainCategory; //メインカテゴリー
use App\Models\Categories\SubCategory; //サブカテゴリー
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use App\Http\Requests\MainCategoryRequest; //メインカテゴリーのバリデーション
use App\Http\Requests\SubCategoryRequest; //サブカテゴリーのバリデーション
use App\Http\Requests\EditRequest; //投稿編集のバリデーション
use App\Http\Requests\CommentRequest; //コメントのバリデーション
use Auth;

class PostsController extends Controller
{
    public function show(Request $request)
    {
        //投稿一覧
        $posts = Post::with('user', 'postComments')->get();
        //$users = User::withCount('likes')->get();
        //dd($users);
        $categories = MainCategory::get();
        $sub_categories = SubCategory::get();
        $like = new Like;
        //ddd($like);
        $post_comment = new Post;
        //$sub_categories_search = SubCategory::with('posts')->get();
        if (!empty($request->keyword)) { //検索窓で検索
            $posts = Post::with('user', 'postComments', 'subCategories') //subCategories追加
                ->where('post_title', 'like', '%' . $request->keyword . '%') //リクエストされたname=keywordがPostテーブルのpost_titleと部分一致することが条件
                ->orWhere('post', 'like', '%' . $request->keyword . '%') //またはリクエストされたname=keywordがPostテーブルのpostと部分一致することが条件
                ->whereHas('subCategories', function ($query) use ($request) {
                    $query->where('sub_category', '=', $request->keyword);
                })->get();
            //->orWhere('sub_category', '=', $request->keyword)
            //$sub_categories_search = SubCategory::with('posts')
            //->where('sub_category', '=', $request->keyword)->get();
        } else if ($request->category_word) { //サブカテゴリーから検索
            $sub_category = $request->category_word;
            $posts = Post::with('user', 'postComments')->get();
        } else if ($request->like_posts) { //いいねした投稿を表示
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
                ->whereIn('id', $likes)->get();
        } else if ($request->my_posts) { //自分の投稿を表示
            $posts = Post::with('user', 'postComments')
                ->where('user_id', Auth::id())->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'sub_categories', 'like', 'post_comment'));
    }

    //投稿詳細画面
    public function postDetail($post_id)
    {
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    //投稿画面
    public function postInput()
    {
        $main_categories = MainCategory::get();
        $sub_categories = SubCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories', 'sub_categories'));
    }

    //投稿登録
    public function postCreate(PostFormRequest $request)
    {
        $sub_category = $request->post_category_id;

        $post_get = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        //中間テーブルに保存する記述する
        $post = Post::findOrFail($post_get->id); //Postテーブルから$post_getで登録されたidを取得
        $post->subCategories()->attach($sub_category); //上記で取得できたidとモデルでリレーションしたsubCategoriesとリクエストで飛んできたpost_category_idを紐付け
        return redirect()->route('post.show');
    }

    //投稿編集
    public function postEdit(EditRequest $request)
    {
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    //投稿削除
    public function postDelete($id)
    {
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }

    //メインカテゴリー登録の追加
    public function mainCategoryCreate(MainCategoryRequest $request)
    {
        //$main_categories = MainCategory::get();
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input'); //, [$main_category_id] , compact('main_categories')
    }

    //サブカテゴリー登録の追加
    public function subCategoryCreate(SubCategoryRequest $request)
    {
        SubCategory::create([
            'main_category_id' => $request->main_category_id, //bladeでmain_category_idの値(value)がmain_categoryのidのため保存されるのは数字(id)になる
            'sub_category' => $request->sub_category_name
        ]);
        return redirect()->route('post.input'); //, [$main_category_id]
    }

    public function commentCreate(CommentRequest $request) //コメント機能
    {
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard()
    {
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard()
    {
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    //投稿にいいねをした時の処理
    public function postLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like; //Likeモデルをインスタンス化

        $like->like_user_id = $user_id; //likeテーブルのlike_user_idにログインユーザーのidを代入
        $like->like_post_id = $post_id; //likeテーブルのlike_post_idにリクエストで送られてきたpost_idを代入
        $like->save();

        return response()->json();
    }

    //投稿へのいいねを解除する処理
    public function postUnLike(Request $request)
    {
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
            ->where('like_post_id', $post_id)
            ->delete();

        return response()->json();
    }
}
