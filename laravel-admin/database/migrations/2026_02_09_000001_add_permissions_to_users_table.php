<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('can_view_students')->default(true)->after('role');
            $table->boolean('can_view_staff')->default(true)->after('can_view_students');
            $table->boolean('can_view_fees')->default(true)->after('can_view_staff');
            $table->boolean('can_view_academics')->default(true)->after('can_view_fees');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'can_view_students',
                'can_view_staff',
                'can_view_fees',
                'can_view_academics',
            ]);
        });
    }
};

