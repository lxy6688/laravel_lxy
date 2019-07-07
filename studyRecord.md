laravel �ļ������ԣ�
        ���ļ򵥣� ���� container
        ���ӵ�ʵ��   config/app.php  
        laravel �ĺ��Ļ��ƣ�  ÿһ�����ܶ����Կ�����һ��server������·�ɣ��������أ���ͼ��Ⱦ��Ȩ����֤������ȣ����������Ŀ�ܣ���Щ���ܿ����Ǽ�����php�ĺ����ڲ������Ƕ�laravel��˵�����Ƕ��Ƕ�����ģ�飬ͨ�� provider ע�ᵽ��ܺ��� container




һ���򵥵����Ž̳�
    1��php   artisan �������ɿ������ļ�
php artisan make:controller ArticleController    �����ͻ�����һ�� ArticleController.php �ļ�, ���������Ѿ������ˣ����ǻ��и�ţ�Ƶķ�ʽ

��ţ�Ƶķ�ʽ��
php artisan make:controller ArticleController --resource    //��ɾ�Ĳ�ķ�������ע���Զ�д�ã� ���Ǿ������ɾ�Ĳ���߼�ҵ����룬����Ҫ�Լ�д


�����༶Ŀ¼�µĿ�����
* ����һ��app/Http/Controllers/Admin/ArticleController.php
* php artisan make:controller Admin/ArticleController --resource


·�ɲ����У�����һһԼ��·�ɲ����ĸ�ʽ����һ��ȫ�����ã�
�ҵ� app/Providers/RouteServiceProvider.php ����ļ�������ȫ��Լ��
public function boot(){
    Route::pattern('id', '[0-9]+');   //���д�id��·�ɲ�������ֻ�ܴ�����, ������һ��һ����·���е�������

parent::boot();
}


�����ļ�
configĿ¼�µ�����  �� ��Ŀ¼�� .env�ļ� �Ĺ���

config/app.php ���� ʱ�� �� ����
'timezone' => 'PRC',   //�й���ʱ���� PRC ������UTC

'locale' => 'zh-CN',  // ��en��Ϊ����  zh-CN



��Ǩ�ƣ�  migration
������Ǩ���ļ���
php artisan make:migration create_articles_table

$table->softDeletes(); //  Ϊ������һ��deleted_at �ֶΣ� ��¼ɾ��������


�����ɵı�Ǩ���ļ�����������Լ����ø��ֱ�ṹ��
2019_07_04_033706_create_articles_table.php


ִ��Ǩ���ļ���
php artisan migrate


��users������� deleted_at �ֶΣ�
������Ǩ���ļ���
php artisan make:migration add_deleted_at_to_users_table  --table=users

��Ǩ�Ʊ�����ӣ�
public function up()   
    {
        //
        Schema::table('users',function(Blueprint $table){
            $table->softDeletes();
        });
    }

�������ʱ������ʹ�õ��� Schema::create;
�༭���ʱ������ʹ�õ��� Schema::table��

Ȼ��ִ�У�
php artisan migrate



**// down()�����о��ǻ��˵�����
Schema::table('users',function(Blueprint $table){
            $table->dropColumn('deleted_at');
});

php artisan migrate:rollback       //���˵���һ�ε�Ǩ�ƣ�ͬʱִ���ϴ�Ǩ���ļ��е�down����



**//�޸ı��ֶ�
��Ҫ����dbal��չ�����Ȱ�װ��
composer require doctrine/dbal


��֮��
up ��д��ҪǨ�Ƶ����ݣ�
down ��д���˵����ݣ�


���ݿ��ʼ������䣺
a) ��������ļ�
php artisan make:seeder ArticlesTableSeeder      �������һ�� database/seeds/ArticlesTableSeeder.php �ļ�

��DB��д����������֮��
DB::table('articles')->insert(
            [
                [
                    'category_id'=>4,
                    'title' => '����4',
                    'content'=> '����4'
                ],
                [
                    'category_id'=>5,
                    'title' => '����5',
                    'content'=> '����5'
                ],
            ]
);

�� DatabaseSeeder.php�У���������ļ���ִ��˳��
public function run()
{
        $this->call(ArticlesTableSeeder::class);
}


b) ִ������ļ�
php artisan db:seed



���ݿ��ѯ- DB���ѯ
������ʾ��������
php artisan make:controller DatabaseController




 ����(collection)    https://baijunyao.com/article/141   ��ʮ��  ����
**//���Ͽ�������������ȥ����ȡֵ��ȥѭ��
DatabaseController.php/getCollect    ���ϵ�demo

**//���ϵ�ţ��֮�����ڣ�
���ϵ���ʽ����,   �ο��ٷ��ĵ��� https://learnku.com/docs/laravel/5.5/collections/1317


**// �����ݿ�ȡ�������ݣ�Ĭ�϶��Ƿ��ض��󼯺���ʽ�� ����ʹ�� ->toArray()ת�����飬 ����ֱ�Ӽ��ϲ���(����ֱ�Ӽ��ϲ���)


(ʮһ) ģ�� Eloquent   ORM 
ģ�� ORM ���ǰ����ݿ�ı�ӳ�䵽ģ����

a) ����ģ�� (ģ��ʹ�� ���շ�������)   ��һ���Ǹ�����ʽ, model һ���� �շ巨����ĵ�����ʽ
articles ��� Model�ļ��� Article.php
image_types ��� Model�ļ��� ImageType.php

b) ���� Model �ļ�
php artisan make:model Models/Article     // �� app/Models Ŀ¼������ Article.php �ļ�

c) ����model
�½�һ�� ModelController  �������� php artisan make:controller ModelController --resource

ģ�͵���ɾ�Ĳ��demo, ���� ModelController ������


����create�� ��Ҫ�� model ���ȶ���������뵽���ݿ���ֶΣ� ����� ����

ɾ��delete��
�������ɾ��(�߼�ɾ��)����ô��Ҫ�� model�������ã�
class Article extends Model
{
    use SoftDeletes;    //������ɾ���� ���� deleted_at �ֶξͻ��¼ʱ�䣬��ʾɾ����ʱ��
    .......
}

������������ã���ô������ɾ����
�����������ɾ����������ɾ�����Ǿ���ǿ��ɾ��  


https://baijunyao.com/?page=7



��ͼ�Ĳ����� https://baijunyao.com/article/143      �����γ�ѧϰ��һ���䡣



�����м��γ�ѧϰ
    





