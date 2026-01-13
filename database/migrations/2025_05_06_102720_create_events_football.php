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
        Schema::create('events_football', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->primary('id');            
            
            $table->string('home_team');
            $table->string('away_team');
            $table->unsignedTinyInteger('home_score')->nullable();
            $table->unsignedTinyInteger('away_score')->nullable();

            $table->dateTime('start_time');
            $table->string('competition');
            $table->string('season');
            $table->string('stadium');
            $table->string('city');
            $table->string('country');


            $table->enum('status', ['scheduled', 'in_progress', 'ended', 'deleted'])->default('scheduled');
            $table->boolean('liveBlock')->default(true);


            $table->decimal('quote_1', 6, 3);
            $table->decimal('quote_X', 6, 3);
            $table->decimal('quote_2', 6, 3);
        });

        Schema::table('events_football', function (Blueprint $table) {
            $table->foreign('id')->references('id')->on('events')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events_football');
    }
};
