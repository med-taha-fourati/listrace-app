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
        Schema::create('command_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('origin_command')
                ->constrained('commands')
                ->onDelete('cascade');

            $table->foreignId('origin_listing')
                ->constrained('listings')
                ->onDelete('cascade');

            $table->foreignId('origin_listing_subentry')
                ->nullable()
                ->constrained('subentries')
                ->onDelete('cascade');

            $table->string('name', 50);
            $table->string('surname', 100);
            $table->string('place_of_origin', 50);
            $table->timestamp('date_of_birth');

            $table->timestamp('begin_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->integer('calculated_price')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('command_details');
    }
};
