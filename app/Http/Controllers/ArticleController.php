<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return "这里是index方法";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return "这里是create方法";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return "这里是store方法";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id, $name)
    {
        //Request $request  这是一个请求参数的类,请求参数是指url中问好? 后面跟着的参数
        $music = $request->input('music');  //推荐使用
        $book = request()->input('book');   //这是request()助手函数，全局在哪都可以使用
        echo $id.'-'.$name.'-'.$music.'-'.$book;

        //获取全部请求参数
        dump($request->all());
        //或者
        //dd($request->all());  //dd()函数打印并返回，也就是不再执行下面的代码

        //从一大堆请求中获取指定的请求参数
        dump($request->only('music'));  //返回一个数组

        //如果排除某个参数，剩下的都要
        dump($request->except('music'));  //返回一个数组
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
