<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGaragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garages', function (Blueprint $table) {
            $table->increments('id');
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->string('name');
            $table->string('short_description');
            $table->text('description');
            $table->string('phone_number');
            $table->string('address');
            $table->string('website')->nullable();
            $table->unsignedInteger('province_id')->index();
            $table->unsignedInteger('district_id')->index();
            $table->unsignedInteger('ward_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->string('working_time')->default('7:30 AM - 6:30 PM');
            $table->double('rating')->default(0);
            $table->unsignedInteger('status')->default(0);
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
        Schema::dropIfExists('garages');
    }
}
