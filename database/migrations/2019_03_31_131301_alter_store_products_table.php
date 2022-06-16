<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStoreProductsTable extends Migration
{
    private $table = 'store_products';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn(['price1']);
            $table->dropColumn(['price2']);
            $table->dropColumn(['price3']);

            $table->dropColumn(['weight1']);
            $table->dropColumn(['weight2']);
            $table->dropColumn(['weight3']);
        });

        Schema::table($this->table, function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn(['category_id']);

            $table->string('weight1', 10);
            $table->float('price1');
            $table->string('weight2', 10);
            $table->float('price2');
            $table->string('weight3', 10);
            $table->float('price3');
        });
    }
}
