<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('mimeType', 100);
            $table->string('extension', 100)->nullable();
            $table->integer('size')->unsigned();
            $table->string('imageable_type');
            $table->integer('imageable_id');
            $table->json('crop')->nullable();
            $table->integer('sort')->unsigned()->nullable();
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
        Schema::dropIfExists('images');
    }
}
