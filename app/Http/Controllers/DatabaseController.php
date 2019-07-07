<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

/**
 * 增删改查演示控制器
 * Class DatabaseController
 * @package App\Http\Controllers
 */
class DatabaseController extends Controller
{
    /**
     * 插入数据
     */
    public function insert(){
        DB::table("articles")->insert([
            [
                "category_id" => 2,
                "title" => "文章2",
                "content" => "内容2"
            ],
            [
                "category_id" => 3,
                "title" => "文章3",
                "content" => "内容3"
            ]
        ]);
    }

    /**
     * 查询数据
     *
     * 拼接查询参数 , 参考博客总结  https://baijunyao.com/article/140
     */
    public function get(){
        $data = DB::table('articles')->get();
        foreach($data as $v){
            dump($v);
            dump($v->content);  //用集合的方式获取值
        }
        //dump($data);

        //有限制的查询
        $res = DB::table('articles')
            ->select('category_id','title','content')
            ->where('title','<>','文章1')
            ->whereIn('id',[1,2,3])
            ->groupBy('category_id')
            ->orderBy('id','desc')
            ->limit(1)
            ->first();   //返回一维数组的集合对象的一个实例形式  如果是 ->get(); 返回二维数组集合实例
        dump($res);
    }

    /**
     * 集合collection
     * 5.5官网集合用法：  https://learnku.com/docs/laravel/5.5/collections/1317
     *
     */
    public function getCollect(){
        $arr = ['','阳',0,'晓',false,'刘',null,'客','博'];
        //调用collect()函数,把数组变成集合
        $collect = collect($arr);
        dump($collect[1]);

        /**
         * 集合的链式操作
         * forget() 删除 阳 字
         * filter() 过滤为假的值
         * implode() 用 - 连接
         */
        dump($collect->forget(1)->filter()->implode('-'));

        //取title列的值
        $testData = DB::table('articles')->where('id','>',1)->get()->pluck('title')->implode('-');
//        foreach($testData as $v){
//            dump($v);   //直接打印title的值
//        }
        dump($testData);
    }
}
