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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('short-desc', 200);
            $table->longText('long-desc');
            $table->string('location', 50);

            $table->foreignId('type')
                ->references('id')
                ->on('types')
                ->constrained()
                ->nullable()
                ->onDelete('cascade');
            
            $table->integer('price-min');
            $table->integer('price-max');
            $table->tinyInteger('status');
            $table->integer('likes')->unsigned()->default(0);

            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
