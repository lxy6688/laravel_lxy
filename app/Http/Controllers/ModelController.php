<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ModelController extends Controller
{
    /**
     *调用模型query
     * @return \Illuminate\Http\Response
     */
    public function index(Article $articleModel)
    {
        $data = $articleModel->get();
        dump($data->toArray());  //$data返回一个集合类，很多内容，我们用toArray()只取数组

        /**
         * 注意，用DB类获取的结果本身就是一个数组的集合，所以不能再用toArray(),否则会报错
         */

        //也可以用静态的方式直接调用get
        $data = Article::get()->toArray();
        dump($data);

        //还可以链式调用
        $data = Article::select('category_id','title','content')
            ->where('title','<>','文章1')
            ->whereIn('id',[1,2,3])
            ->groupBy('category_id')
            ->orderBy('id','desc')
            ->get();
        dump($data->toArray());
    }

    /**
     * MVC的设计思想中，一般在controller层只进行数据的转发与校验, 业务逻辑和调用数据库代码都在model层
     * 有一般，就有特殊，MVC的分层不是严格死的，如果我们从数据库直接获取的数据不需要再逻辑处理，可以直接返回给前端的话，
     * 那么就不必走model层，在C层直接调用数据库的操作即可。
     *
     * 总之，C层负责数据转发、校验和返回数据，尽可能的精简，不要臃肿
     * 业务逻辑绝大部分在model层，model层还可以细分出一个server层和数据访问层
     * server就是业务逻辑处理， 数据访问层就是进行数据库操作的代码。
     */
    public function get(Article $articleModel){
        $data = $articleModel->articleList();
        dump($data->toArray());
    }



    /**
     * 插入数据
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Article $articleModel)
    {
        $data = [
            'category_id' => 6,
            'title' => '文章6',
            'content' => '内容6'
        ];

        $res = $articleModel->create($data);
        dump($res);     //返回添加的内容
        dump($res->id);  //返回添加成功的id
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $articleModel)
    {
        $id = 5;
        $data = [
            'category_id' => 5,
            'title' => '文章666',
            'content' => '内容6667'
        ];
        $res = $articleModel->where('id',$id)->update($data);
        dump($res);   //返回更新的行数
    }

    /**
     * 删除方法(软删除、逻辑删除)
     * 模型默认没有开启软删除，需要在 $articleModel 中配置
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Article $articleModel)
    {
        $id = 5;
//        $res = $articleModel->where('id',$id)->delete();
//        dump($res);   //返回软删除的行数，  软删除是指deleted_at 字段有值不为null，软删除后，普通查询也就查不出来

        //如果想查询软删除的记录
        dump(Article::withTrashed()->get()->toArray());

        //如果只查询被软删除的
        dump(Article::onlyTrashed()->get()->toArray());

        //实现回收站的恢复功能, 调用restore方法
        $articleModel->where('id',$id)->restore();  //返回恢复的行数

        //如果要彻底删除
        dump($articleModel->where('id',$id)->forceDelete());    //返回删除的行数
    }
}
