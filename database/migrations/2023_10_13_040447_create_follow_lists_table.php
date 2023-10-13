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
        Schema::create('follow_lists', function (Blueprint $table) {
            DB::statement('create view follow_lists as select x.user_id as user_id, y.user_name as user_name, x.shop_id as shop_id, z.shop_id as shop_hash_id, z.shop_num as shop_num, z.shop_name as shop_name, z.genre_id as genre_id, z.genre_name as genre_name, z.reserve as reserve, z.pr_img_1 as pr_img_1, z.pr_img_2 as pr_img_2, z.pr_img_3 as pr_img_3, z.pr_txt_1 as pr_txt_1, z.pr_txt_2 as pr_txt_2, z.pr_txt_3 as pr_txt_3, z.area as area, z.instagram as instagram, z.twitter as twitter, z.facebook as facebook, z.homepage as homepage, z.shop_img as shop_img, z.shop_tag as shop_tag from follows as x left join costomers as y on x.user_id = y.user_id left join shop_lists as z on x.shop_id = z.id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_lists');
    }
};
