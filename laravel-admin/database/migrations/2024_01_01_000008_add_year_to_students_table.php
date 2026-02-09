<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedSmallInteger('year')->default((int) date('Y'))->after('section');
        });

        // Backfill existing rows: year = year(created_at)
        \DB::table('students')->update([
            'year' => \DB::raw('YEAR(created_at)'),
        ]);
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('year');
        });
    }
};
