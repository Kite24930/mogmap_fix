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
        Schema::create('favorite_lists', function (Blueprint $table) {
            DB::statement('create view favorite_lists as select x.shop_id as shop_id, x.place_id as place_id, y.place_name as place_name, y.address as address, y.lat as lat, y.lng as lng, y.status as status from favorites as x left join places as y on x.place_id = y.id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_lists');
    }
};
