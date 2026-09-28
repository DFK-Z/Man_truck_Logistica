<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
Schema::create('trucks', function (Blueprint $table) {
        $table->id();
        $table->string('brand');
        $table->string('model');
        $table->integer('year');
        $table->decimal('price', 12, 2);
        $table->string('image')->nullable();
        $table->text('description');
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
