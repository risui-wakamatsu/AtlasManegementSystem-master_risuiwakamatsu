<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

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
        // リレーションの定義
    }

    // コメントをカウントするコード
    public function commentCounts($post_id)
    {
        return Post::with('postComments')->find($post_id)->postComments(); //PostモデルのidとpostCommentsメソッドのリレーション先のpost_idをfind()で返す
    }
}
