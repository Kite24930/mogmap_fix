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
        Schema::create('set_up_lists', function (Blueprint $table) {
            DB::statement('create view set_up_lists as select x.id as id, x.shop_id as shop_id, x.date as date, x.place_id as place_id, y.place_name as place_name, y.address as address, y.lat as lat, y.lng as lng, x.event_id as event_id, z.event_name as event_name, z.event_place_num as event_place_num, z.event_address as event_address, z.event_lat as event_lat, z.event_lng as event_lng, x.start_time as start_time, x.end_time as end_time, x.comment as comment from set_ups as x left join places as y on x.place_id = y.id left join event_lists as z on x.event_id = z.event_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set_up_lists');
    }
};
