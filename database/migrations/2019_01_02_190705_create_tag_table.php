<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTable extends Migration
{
    protected $connection = 'db_blog';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)->create('tag', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();

            $table->string('name', 128)->unique()->comment('标签名称');
            $table->string('description', 1024)->comment('标签描述');
        });

        \DB::connection($this->connection)->statement("ALTER TABLE `tag` comment'标签详情表'"); // 表注释
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)->dropIfExists('tag');
    }
}
