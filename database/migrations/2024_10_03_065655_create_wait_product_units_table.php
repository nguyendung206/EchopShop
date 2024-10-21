<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wait_product_units', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('remain')->nullable();
            $table->unsignedBigInteger('wait_product_id')->nullable();
            $table->foreign('wait_product_id')->references('id')->on('wait_products')->onDelete('cascade');
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
        Schema::dropIfExists('wait_product_units');
    }
};
