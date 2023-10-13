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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('shop_id', 64);
            $table->integer('shop_num')->unsigned();
            $table->string('shop_name');
            $table->integer('genre_id');
            $table->text('reserve');
            $table->string('pr_img_1')->nullable();
            $table->string('pr_img_2')->nullable();
            $table->string('pr_img_3')->nullable();
            $table->string('pr_txt_1')->nullable();
            $table->string('pr_txt_2')->nullable();
            $table->string('pr_txt_3')->nullable();
            $table->string('area');
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('facebook')->nullable();
            $table->string('homepage')->nullable();
            $table->string('shop_img');
            $table->string('shop_tag')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
