<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    /**
     * 允许赋值的字段, 但是如果字段很多，一个个的定义也挺麻烦的
     */
    //protected $fillable = ['category_id','title','content'];

    /**
     * 不允许赋值的字段,注意：这个字段和 $fillable 不能同时使用
     */
    protected $guarded = [];   //定义一个空数组, 意味着所有的字段都可以赋值

    /**
     * 获取文章列表
     * @return mixed
     */
    public function articleList(){
        $data = self::get();
        $data = $this->get();
        return $data;
    }


}
