<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    protected $connection = 'db_blog';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->create('article', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            $table->string('title')->comment('文章标题');
            $table->string('author', 128)->comment('文章作者');
            $table->string('summary', 512)->comment('文章摘要');
            $table->mediumText('content_md')->comment('文章内容(markdown格式)');
            $table->mediumText('content_html')->comment('文章内容(html格式)');
            $table->string('tags_json', 512)->comment('文章标签，包含多个标签组成的json字符串');
            $table->tinyInteger('status', false, true)->comment('文章状态，状态定义参考文档');
        });

        \DB::connection($this->connection)->statement("ALTER TABLE `article` comment'文章详情表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)->dropIfExists('article');
    }
}
