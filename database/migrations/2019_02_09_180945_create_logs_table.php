<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    private $table = 'logs';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('uri', 255);
            $table->string('user_agent', 255);
            $table->string('ip', 20)->nullable();
            $table->string('method', 10)->nullable();
            $table->string('class', 255);
            $table->text('object_old');
            $table->text('object_new')->nullable();
            $table->tinyInteger('type')->unsigned()->default(0)->comment('');
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
