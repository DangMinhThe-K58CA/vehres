<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNullableForAdminUnitsGarageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('garages', function (Blueprint $table) {
            $table->unsignedInteger('province_id')->nullable()->change();
            $table->unsignedInteger('district_id')->nullable()->change();
            $table->unsignedInteger('ward_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('garages', function (Blueprint $table) {
            $table->unsignedInteger('province_id')->nullable(false)->change();
            $table->unsignedInteger('district_id')->nullable(false)->change();
            $table->unsignedInteger('ward_id')->nullable(false)->change();
        });
    }
}
