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
        Schema::create('hostels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('user_type')->comment('two type of user (user,admin)');
            $table->string('name')->unique();
            $table->longText('hostel_rules');
            $table->longText('description');
            $table->longText('facilities');
            $table->integer('rating')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->longText('address');
            $table->tinyInteger('status')->default(0)->comment('0 = pending, 1 = active');
            $table->string('offer')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hostels');
    }
};
