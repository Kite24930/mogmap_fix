<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('set_ups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('shop_id')->unsigned();
            $table->date('date');
            $table->integer('place_id')->nullable();
            $table->integer('event_id')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->text('comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set_ups');
    }
};
