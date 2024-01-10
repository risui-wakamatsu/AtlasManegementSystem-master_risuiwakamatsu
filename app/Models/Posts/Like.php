<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'like_user_id',
        'like_post_id'
    ];

    public function user() //usersテーブルとリレーション
    {
        return $this->belongsTo('App\Models\Users\User');
    }

    //いいねをカウントするメソッド
    public function likeCounts($post_id)
    {
        return $this->where('like_post_id', $post_id)->get()->count(); //LIkeモデルのlike_post_idがpost_idの人を取得
    }

    //postテーブルとリレーション追加
    public function post()
    {
        return $this->belongsTo('App\Models\Posts\Post');
    }
}
