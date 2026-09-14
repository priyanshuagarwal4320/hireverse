<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('results', function (Blueprint $table) {
            $table->unsignedTinyInteger('communication_rating')->nullable()->after('interview_id');
            $table->unsignedTinyInteger('technical_rating')->nullable()->after('communication_rating');
            $table->unsignedTinyInteger('culture_fit_rating')->nullable()->after('technical_rating');
        });
    }

    public function down(): void
    {
        Schema::table('results', function (Blueprint $table) {
            $table->dropColumn(['communication_rating', 'technical_rating', 'culture_fit_rating']);
        });
    }
};