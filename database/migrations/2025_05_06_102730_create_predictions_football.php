<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create the events_football table.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('predictions_football', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');            
        
            $table->boolean('predicted_1')->default(false);
            $table->boolean('predicted_X')->default(false);
            $table->boolean('predicted_2')->default(false);
        });

        Schema::table('predictions_football', function (Blueprint $table) {
            $table->foreign('id')->references('id')->on('predictions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('predictions_football');
    }
};