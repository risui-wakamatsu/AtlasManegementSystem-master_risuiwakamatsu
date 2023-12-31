<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'main_category_id',
        'main_category',
        'sub_category',
    ];

    public function subCategory() //main1対sub多
    {
        // subcategoryとリレーションの定義
        return $this->hasMany('App\Models\Categories\SubCategory', 'main_category_id');
    }
}
