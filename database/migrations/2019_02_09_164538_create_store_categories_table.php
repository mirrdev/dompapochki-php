<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreCategoriesTable extends Migration
{
    private $table = 'store_categories';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->text('text')->nullable();
            $table->integer('user_id');
            $table->integer('seo_id');
            $table->integer('parent_id')->nullable();
            $table->string('slug', 255);
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->string('filepath', 255);
            $table->tinyInteger('show_on_homepage')->unsigned()->default(0);
            $table->tinyInteger('show_in_navigate')->unsigned()->default(0);
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
        Schema::dropIfExists($this->table);
    }
}
