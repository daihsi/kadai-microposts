<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
{
    public function index()
    {
        //ユーザー一覧をidの降順で取得
        $users = User::orderBy('id', 'desc')->paginate(10);
        
        return view('users.index', [
            'users' => $users,
        ]);
    }
    
    public function show($id)
    {
        //idの値でユーザーを検索して取得
        $user = User::findOrFail($id);
        
        //モデル件数をロード
        $user->loadRelationshipCounts();
        
        //ユーザーの投稿を作成日時の降順で取得
        $microposts = $user->microposts()->orderBy('created_at', 'desc')->paginate(10);
        
        //ユーザー詳細ビューで表示
        return view('users.show', [
            'user' => $user,
            'microposts' => $microposts,
        ]);
    }
}