<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // In some dev environments this migration may have already been applied.
        // Only add the column if it does not exist to avoid duplicate-column errors.
        if (! Schema::hasColumn('students', 'year')) {
            Schema::table('students', function (Blueprint $table) {
                $table->unsignedSmallInteger('year')->default((int) date('Y'))->after('section');
            });

            // Best‑effort backfill for non‑SQLite drivers.
            if (config('database.default') !== 'sqlite') {
                \DB::table('students')->update([
                    'year' => \DB::raw('YEAR(created_at)'),
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('year');
        });
    }
};
