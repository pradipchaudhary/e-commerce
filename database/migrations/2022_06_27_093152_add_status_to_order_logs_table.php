<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToOrderLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_logs', function (Blueprint $table) {
            $table->boolean('is_paid')->default(0);
            $table->boolean('is_dispatch')->default(0);
            $table->boolean('is_delivered')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_logs', function (Blueprint $table) {
            //
        });
    }
}
