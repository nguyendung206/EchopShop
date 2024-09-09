<?php

use App\Enums\UserGender;
use App\Enums\UserStatus;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('citizen_identification_number')->nullable();
            $table->dateTime('date_of_issue')->nullable();
            $table->string('place_of_issue')->nullable();
            $table->dateTime('date_of_birth')->nullable();
            $table->tinyInteger('gender')->unsigned()->default(UserGender::Male);
            $table->integer('rank_id')->default(1);
            $table->string('address')->nullable();
            $table->bigInteger('province_id')->nullable();
            $table->bigInteger('district_id')->nullable();
            $table->bigInteger('ward_id')->nullable();
            $table->tinyInteger('status')->unsigned()->default(UserStatus::Active);
            $table->bigInteger('shop_id')->nullable();
            $table->integer('role')->default(1);
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
        Schema::dropIfExists('users');
    }
};
