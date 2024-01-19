<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;
use app\Models\Posts\Posts;

class SubCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'main_category',
        'main_category_id',
        'sub_category',
        'sub_category_name',
    ];
    public function mainCategory() //sub多対main1
    {
        // maincategoryとリレーションの定義
        return $this->belongsTo('App\Models\Categories\MainCategory');
    }

    public function posts()
    {
        // リレーションの定義
        return $this->belongsToMany(Posts::class, 'post_sub_categories', 'post_id', 'sub_category_id');
        //(使用するモデル,使用するテーブル,リレーション元のidを入れた中間テーブルのカラム,リレーション先のidを入れた中間テーブルのカラム)

    }
}
