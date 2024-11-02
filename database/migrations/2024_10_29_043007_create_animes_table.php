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
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('about');
            $table->unsignedBigInteger('author');
            $table->foreign('author')->references('id')->on('authors');
            $table->unsignedBigInteger('status');
            $table->foreign('status')->references('id')->on('statuses');
            $table->unsignedBigInteger('studio');
            $table->foreign('studio')->references('id')->on('studios');
            $table->integer('yearOfRelease')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
