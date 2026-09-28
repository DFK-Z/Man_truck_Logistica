<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Удаляем старую таблицу
        Schema::dropIfExists('trucks');

        // Создаем новую с правильными колонками
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->decimal('price', 12, 2);
            $table->string('image')->nullable();
            $table->text('description');
            $table->string('engine')->nullable();        // ← ДОБАВЛЕНО
            $table->string('transmission')->nullable();  // ← ДОБАВЛЕНО
            $table->integer('mileage')->nullable();      // ← ДОБАВЛЕНО
            $table->boolean('is_available')->default(true);
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
