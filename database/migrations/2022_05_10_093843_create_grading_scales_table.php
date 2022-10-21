<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradingScalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grading_scales', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('grade_id');
            $table->text('apperance')->nullable();
            $table->text('screen')->nullable();
            $table->text('bezel')->nullable();
            $table->text('other')->nullable();
            $table->text('functionality')->nullable();
            $table->text('lcd')->nullable();
            $table->unsignedInteger('entered_by');
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
        Schema::dropIfExists('grading_scales');
    }
}
