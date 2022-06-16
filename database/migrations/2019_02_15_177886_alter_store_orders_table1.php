<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStoreOrdersTable1 extends Migration
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
            $table->dropColumn(['update_date']);
        });

        Schema::table($this->table, function (Blueprint $table) {
            $table->renameColumn('address','delivery_info');
            $table->renameColumn('create_date','created_at');
            $table->timestamp('updated_at')->nullable();
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
            $table->renameColumn('delivery_info','address');
            $table->renameColumn('created_at','create_date');
            $table->renameColumn('updated_at','update_date');
        });
    }
}
