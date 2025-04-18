<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('events')) {
            Schema::create('events', function (Blueprint $table) {
                $table->id();
                $table->string('type'); // DO, SBY, FLT, CI, CO, UNK
                $table->string('flight_number')->nullable(); // For flight events
                $table->string('departure_airport')->nullable();
                $table->string('arrival_airport')->nullable();
                $table->timestamp('start_time');
                $table->timestamp('end_time');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};
