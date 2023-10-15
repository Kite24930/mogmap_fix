<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('same_lists', function (Blueprint $table) {
            DB::statement(' create view same_lists as select date, place_id, place_name, address, lat, lng, count(date) as count from set_up_lists where place_id is not null group by date, place_id order by date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('same_lists');
    }
};
