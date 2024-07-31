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
        Schema::create('subentries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('listing_id')
                ->constrained('listings')
                ->onDelete('cascade');

            $table->string('subentry', 100);
            $table->integer('price');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subentries');
    }
};
