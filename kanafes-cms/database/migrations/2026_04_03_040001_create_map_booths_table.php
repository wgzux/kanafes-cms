<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('map_booths', function (Blueprint $table) {
            $table->id();
            $table->string('group_name');        // VD: "企業ブース", "飲食"
            $table->string('group_color', 7)->default('#8B0000'); // hex color
            $table->string('booth_number');       // VD: "1", "H1"
            $table->string('booth_name');         // VD: "TAKOBAR"
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('map_booths');
    }
};
