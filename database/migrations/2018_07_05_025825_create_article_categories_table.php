<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('分类名');
            $table->integer('parent_id')->nullable()->comment('父级ID');
            $table->integer('show_in_nav')->default(0)->comment('是否导航显示');
            $table->integer('sort')->default(0)->comment('分类排序');
            $table->unsignedInteger('_lft')->nullable()->comment('左');
            $table->unsignedInteger('_rgt')->nullable()->comment('右');
            $table->string('keywords')->nullable()->comment('关键字');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_categories');
    }
}
