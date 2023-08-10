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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('parent_id');
            $table->string('url')->nullable()->default("");
            $table->string('icon')->nullable()->default("");
            $table->string('scope')->nullable()->default("");
            $table->integer('ord')->nullable()->default("0");
            $table->timestamps();
            $table->index(['parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
