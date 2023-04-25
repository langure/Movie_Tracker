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
        Schema::create('movies', function (Blueprint $table) {
            $table->string('name');
            $table->integer('year');
            $table->string('director');
            $table->date('date_watched');
            $table->float('rating', 2, 1);
            $table->integer('running_time_in_minutes');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('movies', function (Blueprint $table) {
            //
        });
    }
};
