<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('path');
            $table->string('format')->nullable();
            $table->string('usage')->nullable();
            $table->longText('description')->nullable();
            $table->boolean('is_public')->default(1);
            $table->integer('user_id');
            $table->integer('assetable_id')->nullable();
            $table->string('assetable_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
