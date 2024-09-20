<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('code')->unique();
            $table->tinyInteger('type');
            $table->float('value')->default(0);
            $table->float('max_value')->default(0);
            $table->string('photo')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('max_uses')->default(0);
            $table->integer('quantity_used')->default(0);
            $table->integer('limit_uses')->default(0);
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
        Schema::dropIfExists('discounts');
    }
};
