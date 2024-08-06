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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('hostel_id');
            $table->string('name');
            $table->string('number');
            $table->string('type')->comment('single,double,flat');
            $table->string('ac_type')->comment('ac/non ac');
            $table->string('rooms_or_beds');
            $table->string('phone');
            $table->string('rent_per_day');
            $table->string('discount')->nullable()->comment('room discount');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
