laravel 的技术特性：
        核心简单， 就是 container
        复杂的实现   config/app.php  
        laravel 的核心机制：  每一个功能都可以看做是一个server，比如路由，请求拦截，视图渲染，权限验证、缓存等，对于其他的框架，这些功能可能是集成在php的核心内部，但是对laravel来说，他们都是独立的模块，通过 provider 注册到框架核心 container




一、简单的入门教程
    1、php   artisan 命令生成控制器文件
php artisan make:controller ArticleController    这样就会生成一个 ArticleController.php 文件, 基础的类已经生成了，但是还有更牛逼的方式

更牛逼的方式：
php artisan make:controller ArticleController --resource    //增删改查的方法名和注释自动写好， 但是具体的增删改查的逻辑业务代码，还需要自己写


创建多级目录下的控制器
* 创建一个app/Http/Controllers/Admin/ArticleController.php
* php artisan make:controller Admin/ArticleController --resource


路由参数中，不必一一约束路由参数的格式，有一个全局设置：
找到 app/Providers/RouteServiceProvider.php 这个文件，定义全局约束
public function boot(){
    Route::pattern('id', '[0-9]+');   //所有带id的路由参数，都只能传数字, 不必在一条一条的路由中单独配置

parent::boot();
}


配置文件
config目录下的配置  和 根目录下 .env文件 的关联

config/app.php 更改 时区 和 语言
'timezone' => 'PRC',   //中国的时区是 PRC ，不是UTC

'locale' => 'zh-CN',  // 把en改为中文  zh-CN



表迁移：  migration
创建表迁移文件：
php artisan make:migration create_articles_table

$table->softDeletes(); //  为表增加一个deleted_at 字段， 记录删除的日期


打开生成的表迁移文件，里面可以自己设置各种表结构：
2019_07_04_033706_create_articles_table.php


执行迁移文件：
php artisan migrate


往users表中添加 deleted_at 字段：
创建表迁移文件：
php artisan make:migration add_deleted_at_to_users_table  --table=users

在迁移表中添加：
public function up()   
    {
        //
        Schema::table('users',function(Blueprint $table){
            $table->softDeletes();
        });
    }

创建表的时候我们使用的是 Schema::create;
编辑表的时候我们使用的是 Schema::table；

然后执行：
php artisan migrate



**// down()方法中就是回退的内容
Schema::table('users',function(Blueprint $table){
            $table->dropColumn('deleted_at');
});

php artisan migrate:rollback       //回退到上一次的迁移，同时执行上次迁移文件中的down方法



**//修改表字段
需要借助dbal扩展包，先安装：
composer require doctrine/dbal


总之：
up 中写需要迁移的内容；
down 中写回退的内容；


数据库初始数据填充：
a) 创建填充文件
php artisan make:seeder ArticlesTableSeeder      这会生成一个 database/seeds/ArticlesTableSeeder.php 文件

用DB类写好填充的数据之后，
DB::table('articles')->insert(
            [
                [
                    'category_id'=>4,
                    'title' => '文章4',
                    'content'=> '内容4'
                ],
                [
                    'category_id'=>5,
                    'title' => '文章5',
                    'content'=> '内容5'
                ],
            ]
);

在 DatabaseSeeder.php中，定义填充文件的执行顺序
public function run()
{
        $this->call(ArticlesTableSeeder::class);
}


b) 执行填充文件
php artisan db:seed



数据库查询- DB类查询
创建演示控制器：
php artisan make:controller DatabaseController




 集合(collection)    https://baijunyao.com/article/141   第十讲  集合
**//集合可以像数组那样去操作取值，去循环
DatabaseController.php/getCollect    集合的demo

**//集合的牛逼之处在于：
集合的链式操作,   参考官方文档： https://learnku.com/docs/laravel/5.5/collections/1317


**// 从数据库取出的数据，默认都是返回对象集合形式， 可以使用 ->toArray()转成数组， 或者直接集合操作(建议直接集合操作)


(十一) 模型 Eloquent   ORM 
模型 ORM 就是把数据库的表映射到模型类

a) 创建模型 (模型使用 大驼峰命名法)   表一般是复数形式, model 一般是 驼峰法命令的单数形式
articles 表的 Model文件是 Article.php
image_types 表的 Model文件是 ImageType.php

b) 创建 Model 文件
php artisan make:model Models/Article     // 在 app/Models 目录下生成 Article.php 文件

c) 调用model
新建一个 ModelController  控制器： php artisan make:controller ModelController --resource

模型的增删改查的demo, 就在 ModelController 中体现


新增create： 需要在 model 中先定义允许插入到数据库的字段， 否则会 报错；

删除delete：
如果是软删除(逻辑删除)，那么需要早 model类中配置：
class Article extends Model
{
    use SoftDeletes;    //设置软删除， 表中 deleted_at 字段就会记录时间，表示删除的时间
    .......
}

如果不进行配置，那么就是真删除；
如果配置了软删除，想真正删除，那就用强制删除  


https://baijunyao.com/?page=7



视图的操作： https://baijunyao.com/article/143      初级课程学习告一段落。



二、中级课程学习
    





