<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page'); // home, about, event, map, sponsor
            $table->string('section'); // hero_title, hero_desc, body_content, etc.
            $table->string('type')->default('text'); // text, html, image
            $table->longText('value')->nullable();
            $table->string('label')->nullable(); // human-readable label for admin
            $table->timestamps();

            $table->unique(['page', 'section']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
