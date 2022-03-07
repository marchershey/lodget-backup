<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address_street');
            $table->string('address_city');
            $table->string('address_state');
            $table->string('address_zip');
            $table->string('listing_headline');
            $table->text('listing_description');
            $table->integer('guest_count');
            $table->integer('bedroom_count');
            $table->integer('bed_count');
            $table->decimal('bathroom_count', 4, 1);
            $table->string('rate');
            $table->string('tax_rate');
            $table->string('calendar_color');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
};
