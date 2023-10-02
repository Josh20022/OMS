<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('texts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('intro')->nullable();
            $table->string('slider')->nullable();
            $table->string('oms_title')->nullable();
            $table->text('oms')->nullable();
            $table->string('method_title')->nullable();
            $table->string('method_subtitle')->nullable();
            $table->string('mission_title')->nullable();
            $table->text('mission')->nullable();
            $table->string('iso')->nullable();
            $table->text('about')->nullable();
            $table->text('details')->nullable();
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
        Schema::dropIfExists('texts');
    }
}
