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
        Schema::create('shop_lists', function (Blueprint $table) {
            DB::statement('create view shop_lists as select x.id as id, x.shop_id as shop_id, x.shop_num as shop_num, x.shop_name as shop_name, x.genre_id as genre_id, y.genre_name as genre_name, x.reserve as reserve, x.pr_img_1 as pr_img_1, x.pr_img_2 as pr_img_2, x.pr_img_3 as pr_img_3, x.pr_txt_1 as pr_txt_1, x.pr_txt_2 as pr_txt_2, x.pr_txt_3 as pr_txt_3, x.area as area, x.instagram as instagram, x.twitter as twitter, x.facebook as facebook, x.homepage as homepage, x.shop_img as shop_img, x.shop_tag as shop_tag, x.status as status from shops as x left join genres as y on x.genre_id = y.id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_lists');
    }
};
