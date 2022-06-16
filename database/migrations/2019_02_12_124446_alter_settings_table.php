<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSettingsTable extends Migration
{
    private $table = 'settings';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn(['value']);
        });
        Schema::table($this->table, function (Blueprint $table) {
            $table->string('key', 100);
            $table->longText('value')->nullable();
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
            $table->dropColumn(['key']);
            $table->dropColumn(['value']);
        });
        Schema::table($this->table, function (Blueprint $table) {
            $table->string('value', 255)->nullable();
        });
    }
}
