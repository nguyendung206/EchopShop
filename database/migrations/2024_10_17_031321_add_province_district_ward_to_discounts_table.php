<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\TypeDiscountScope;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->integer('scope_type')->default(TypeDiscountScope::GLOBAL->value)->after('user_used');
            $table->unsignedBigInteger('province_id')->nullable()->after('user_used');
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->unsignedBigInteger('district_id')->nullable()->after('user_used');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->unsignedBigInteger('ward_id')->nullable()->after('user_used');
            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->dropForeign(['ward_id']);
            $table->dropForeign(['district_id']);
            $table->dropForeign(['province_id']);
            
            $table->dropColumn('scope_type');
            $table->dropColumn('ward_id');
            $table->dropColumn('district_id');
            $table->dropColumn('province_id');
        });
    }
};
