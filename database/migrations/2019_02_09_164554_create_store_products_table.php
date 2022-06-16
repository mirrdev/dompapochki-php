<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreProductsTable extends Migration
{
    private $table = 'store_products';

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
            $table->text('description')->nullable();

            $table->string('name1', 50)->nullable();
            $table->string('detail1', 50)->nullable();
            $table->float('price1', 2)->nullable();

            $table->string('name2', 50)->nullable();
            $table->string('detail2', 50)->nullable();
            $table->float('price2', 2)->nullable();

            $table->string('name3', 50)->nullable();
            $table->string('detail3', 50)->nullable();
            $table->float('price3', 2)->nullable();

            $table->integer('user_id');

            $table->integer('seo_id');
            $table->string('slug', 255);
            $table->enum('label', ['hot','normal','popular'])->default('normal');
            $table->tinyInteger('status')->unsigned()->default(0);
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
