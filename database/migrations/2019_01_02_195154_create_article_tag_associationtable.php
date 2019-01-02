<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTagAssociationTable extends Migration
{
    protected $connection = 'db_blog';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->create('article_tag_association', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->increments('id');
            $table->timestamps();

            $table->integer('article_id')->unsigned()->comment('对应article表中的id');
            $table->integer('tag_id')->unsigned()->comment('对应tag表中的id');

        });

        \DB::connection($this->connection)->statement("ALTER TABLE `article_tag_association` comment'标签详情表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_tag_association');
    }
}
