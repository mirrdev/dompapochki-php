<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreOrdersTable extends Migration
{
    public $table = 'delivery';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('address', 255);
            $table->string('phone', 255);
            $table->string('email', 255)->nullable();
            $table->text('cart');
            $table->text('message');
            $table->integer('status');
            $table->integer('price')->default(0);
            $table->integer('free_delivery')->default(1);
            $table->text('message_admin');
            $table->timestamp('create_date')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('update_date')->default('0000-00-00 00:00:00');
            $table->integer('send')->default(0);
            $table->string('bepaid_token', 255)->nullable();
            $table->string('bepaid_uid', 255)->nullable();
            $table->integer('bepaid_status')->default(0);
            $table->text('address_pay')->nullable();
            $table->text('tg_message');
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
