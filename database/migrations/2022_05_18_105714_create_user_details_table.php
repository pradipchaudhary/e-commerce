<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('business_phone_number_code');
            $table->string('business_phone_number');
            $table->unsignedInteger('whatsapp_code')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('state_id')->nullable();
            $table->text('address')->nullable();
            $table->unsignedInteger('postal_code')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('user_details');
    }
}
