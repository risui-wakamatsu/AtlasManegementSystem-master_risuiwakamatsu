<?php

namespace App\Http\Controllers\Authenticated\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Gate;
use App\Models\Users\User;
use App\Models\Users\Subjects;
use App\Searchs\DisplayUsers;
use App\Searchs\SearchResultFactories;
use Illuminate\Support\Facades\Auth;


class UsersController extends Controller
{

    public function showUsers(Request $request)
    {
        $keyword = $request->keyword;
        $category = $request->category;
        $updown = $request->updown;
        $gender = $request->sex;
        $role = $request->role;
        $subjects = $request->subjects; //ここで検索時の科目を受け取る
        var_dump($subjects);
        //$subjects = Auth::User()->subjects()->get(); //User.phpのsubjectsメソッドを取得
        //$subject_id = Auth::User()->subjects()->pluck('subject_id'); //リレーション先のsubjectのidを取得
        //$subjects = User::with('subject')->whereIn('user_id', $subject_id)->latest()->get();

        $userFactory = new SearchResultFactories(); //SearchResultFactoriesモデルをインスタンス化、モデルをコントローラーで使えるようにするため
        $users = $userFactory->initializeUsers($keyword, $category, $updown, $gender, $role, $subjects);
        //$usersにインスタンスしたモデル(SearchResultFactories)からメソッド(initializeUsers)呼び出し
        $subjects = Subjects::all();
        return view('authenticated.users.search', compact('users', 'subjects'));
    }

    public function userProfile($id)
    {
        $user = User::with('subjects')->findOrFail($id);
        $subject_lists = Subjects::all();
        return view('authenticated.users.profile', compact('user', 'subject_lists'));
    }

    public function userEdit(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->subjects()->sync($request->subjects);
        return redirect()->route('user.profile', ['id' => $request->user_id]);
    }
}
