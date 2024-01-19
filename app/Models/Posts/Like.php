<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Posts\Post;

class Like extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'like_user_id',
        'like_post_id'
    ];

    public function user() //usersテーブルとリレーション
    {
        return $this->belongsTo('App\Models\Users\User'); //命名規則に沿ってない、第二引数以降が必要になる
    }

    //いいねをカウントするメソッド
    public function likeCounts($post_id)
    {
        return $this->where('like_post_id', $post_id)->get()->count(); //LIkeモデルのlike_post_idがpost_idの人を取得
    }

    //postテーブルとリレーション
    public function posts()
    {
        return $this->belongsTo('App\Models\Posts\Post');
    }
}
