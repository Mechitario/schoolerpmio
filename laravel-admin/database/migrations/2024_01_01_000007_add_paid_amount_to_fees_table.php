<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fees', function (Blueprint $table) {
            $table->decimal('paid_amount', 12, 2)->default(0)->after('amount');
        });

        // Backfill: PAID -> paid_amount = amount, else 0
        \DB::table('fees')->where('status', 'PAID')->update([
            'paid_amount' => \DB::raw('amount'),
        ]);
    }

    public function down(): void
    {
        Schema::table('fees', function (Blueprint $table) {
            $table->dropColumn('paid_amount');
        });
    }
};
