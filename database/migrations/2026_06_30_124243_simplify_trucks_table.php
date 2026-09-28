<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trucks', function (Blueprint $table) {
            $table->dropColumn([
                'year', 'price', 'description',
                'engine', 'transmission', 'mileage',
                'is_available'
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('trucks', function (Blueprint $table) {
            $table->integer('year')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('engine')->nullable();
            $table->string('transmission')->nullable();
            $table->integer('mileage')->nullable();
            $table->boolean('is_available')->default(true);
        });
    }
};
