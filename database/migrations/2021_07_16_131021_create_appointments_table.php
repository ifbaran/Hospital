<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->integer('appointmentWorkingTime');
            $table->string('appointmentName')->nullable();
            $table->string('appointmentEmail')->nullable();
            $table->string('appointmentPhone')->nullable();
            $table->string('appointmentDate')->nullable();
            $table->string('appointmentNote')->nullable();
            $table->integer('notification_types')->default(0);
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
        Schema::dropIfExists('appointments');
    }
}
