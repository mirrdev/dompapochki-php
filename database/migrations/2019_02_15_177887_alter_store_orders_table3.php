<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStoreOrdersTable3 extends Migration
{
    private $table = 'store_orders';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->string('home', 255)->nullable();
            $table->string('street', 255)->nullable();
            $table->string('home_korpus', 255)->nullable();
            $table->string('home_podezd', 255)->nullable();
            $table->string('home_etaj', 255)->nullable();
            $table->string('flat', 255)->nullable();
            $table->string('delivery_time', 255)->nullable();
            $table->integer('payment_type')->default(0);
            $table->integer('delivery_type')->default(0);
            $table->string('hash', 255)->nullable();

            $table->unique('hash', 'hash_order');
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
            $table->dropIndex('hash_order');
            $table->dropColumn(['home', 'street', 'home_korpus', 'home_podezd', 'home_etaj', 'flat', 'delivery_time', 'payment_type', 'delivery_type', 'hash']);
        });
    }
}
