<?php

namespace App\Http\Controllers;

use app\admin\library\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dump(session()->all());  //打印session值

        $uid = \Auth::id();     //登录用户的id
        $user = \Auth::user();  //登录用户的详细信息

        dump($uid);
        dump($user);
        return view('home');
    }
}
