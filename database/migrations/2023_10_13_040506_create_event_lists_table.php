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
        Schema::create('event_lists', function (Blueprint $table) {
            DB::statement('create view event_lists as select x.id as event_id, x.event_name as event_name, x.event_place_num as event_place_num, y.place_name as event_place_name, y.address as event_address, y.lat as event_lat, y.lng as event_lng, x.event_date as event_date from events as x left join places as y on x.event_place_num = y.id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_lists');
    }
};
