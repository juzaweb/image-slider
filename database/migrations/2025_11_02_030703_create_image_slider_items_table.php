<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_slider_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('image_slider_id');
            $table->string('link')->nullable();
            $table->boolean('new_tab')->default(false);
            $table->integer('display_order')->default(0);
            $table->datetimes();

            $table->foreign('image_slider_id')
                ->references('id')
                ->on('image_sliders')
                ->onDelete('cascade');
        });

        Schema::create(
            'image_slider_item_translations',
            function (Blueprint $table) {
                $table->id();
                $table->uuid('image_slider_item_id');
                $table->string('locale', 5)->index();

                $table->string('title')->nullable();
                $table->text('description')->nullable();

                $table->unique(['image_slider_item_id', 'locale'], 'image_slider_item_locale_unique');
                $table->foreign('image_slider_item_id')
                    ->references('id')
                    ->on('image_slider_items')
                    ->onDelete('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_slider_item_translations');
        Schema::dropIfExists('image_slider_items');
    }
};
