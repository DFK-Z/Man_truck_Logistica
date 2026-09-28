<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trucks', function (Blueprint $table) {
            $table->string('engine')->nullable()->after('description');
            $table->string('transmission')->nullable()->after('engine');
            $table->integer('mileage')->nullable()->after('transmission');
        });
    }

    public function down(): void
    {
        Schema::table('trucks', function (Blueprint $table) {
            $table->dropColumn(['engine', 'transmission', 'mileage']);
        });
    }
};
