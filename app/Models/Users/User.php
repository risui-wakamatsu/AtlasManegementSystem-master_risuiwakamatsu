<?php

namespace App\Models\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Users\Subjects; //追加
use App\Models\Calendars\ReserveSettings; //追加

use App\Models\Posts\Like;
use Auth;

class User extends Authenticatable
{
    use Notifiable;
    use softDeletes;

    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'over_name',
        'under_name',
        'over_name_kana',
        'under_name_kana',
        'mail_address',
        'sex',
        'birth_day',
        'role',
        'password'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts() //postsテーブルとリレーション
    {
        return $this->hasMany('App\Models\Posts\Post');
    }

    public function calendars()
    {
        return $this->belongsToMany('App\Models\Calendars\Calendar', 'calendar_users', 'user_id', 'calendar_id')->withPivot('user_id', 'id');
    }

    public function reserveSettings()
    {
        return $this->belongsToMany('App\Models\Calendars\ReserveSettings', 'reserve_setting_users', 'user_id', 'reserve_setting_id')->withPivot('id');
    }

    public function subjects()
    { // リレーションの定義
        return $this->belongsToMany(Subjects::class, 'subject_users', 'user_id', 'subject_id')
            ->withPivot('subject_id');
        //(使用するモデル,使用するテーブル,リレーション元のidを入れた中間テーブルのカラム,リレーション先のidを入れた中間テーブルのカラム)
        //withPivot：アクセスしたいカラムを記述
    }

    //likeテーブルとリレーション
    public function likes()
    {
        return $this->hasMany('App\Models\Posts\Like', 'like_user_id'); //命名規則に沿ってない、第二引数以降が必要になる
        //第二引数：参照先の外部キー(Likeテーブルの外部キーを入力)
        //第三引数：参照元の内部キー
    }

    // いいねしているかどうか
    public function is_Like($post_id)
    {
        return Like::where('like_user_id', Auth::id())->where('like_post_id', $post_id)->first(['likes.id']);
    }

    public function likePostId()
    {
        return Like::where('like_user_id', Auth::id()); //like_user_idの値がログインユーザーのデータを取得
    }

    //予約しているか
    //public function is_Reserve($reserve_settings)
    //{    return $this->reserveSettings()->where('reserve_setting_id', $reserve_settings)->first(['reserve_settings.id']);}

    //予約解除
    //public function unreserve($reserve_settings)
    //{  return $this->reserveSettings()->detach($reserve_settings);}
}
