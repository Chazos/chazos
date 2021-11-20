<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_list', function (Blueprint $table) {
            $table->id();
            $table->string('display_name');
            $table->string('model_name')->nullable();
            $table->string('table_name');
            $table->string('slug');
            $table->text('fields');
            $table->text('actions')->nullable();
            $table->text('configure_fields')->nullable();
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
        Schema::dropIfExists('table_list');
    }
}
