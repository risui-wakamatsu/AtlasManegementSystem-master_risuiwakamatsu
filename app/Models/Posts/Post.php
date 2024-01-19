<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use Psy\TabCompletion\Matcher\FunctionsMatcher;
use app\Models\Categories\SubCategories;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user() //usersテーブルとリレーション
    {
        return $this->belongsTo('App\Models\Users\User');
    }

    //コメントとリレーション
    public function postComments()
    {
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    public function subCategories()
    {
        // リレーションの定義 中間テーブル
        return $this->belongsToMany(SubCategories::class, 'post_sub_categories', 'post_id', 'sub_category_id');
        //(使用するモデル,使用するテーブル,リレーション元のidを入れた中間テーブルのカラム,リレーション先のidを入れた中間テーブルのカラム)
    }

    // コメントをカウントするコード
    public function commentCounts($post_id)
    {
        return Post::with('postComments')->find($post_id)->postComments(); //PostモデルのidとpostCommentsメソッドのリレーション先のpost_idをfind()で返す
    }

    //likeテーブルとリレーション
    public function likes()
    {
        return $this->hasMany('App\Models\Posts\Like', 'like_post_id', 'id');
    }
}
