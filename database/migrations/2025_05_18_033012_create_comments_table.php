<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('film_id');
            $table->string('name');
            $table->string('email');
            $table->text('comment');
            $table->unsignedBigInteger('parent_id')->nullable(); // Menambahkan parent_id untuk reply
            $table->timestamps();

            $table->foreign('film_id')->references('id')->on('films')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade'); // Menambahkan relasi dengan tabel comments itu sendiri
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
