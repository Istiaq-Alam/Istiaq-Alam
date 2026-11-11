<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('researches', function (Blueprint $table) {
            $table->longText('pdf')->nullable()->after('thumbnail');
        });
    }

    public function down(): void
    {
        Schema::table('researches', function (Blueprint $table) {
            $table->dropColumn('pdf');
        });
    }
};
