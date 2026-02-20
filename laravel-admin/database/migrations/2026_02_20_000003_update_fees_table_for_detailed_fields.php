<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fees', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->after('student_id')->constrained('parents')->nullOnDelete();
            $table->date('payment_date')->nullable()->after('month');
            $table->decimal('copy_fee', 12, 2)->default(0)->after('paid_date');
            $table->decimal('dress_fee', 12, 2)->default(0)->after('copy_fee');
            $table->decimal('book_fee', 12, 2)->default(0)->after('dress_fee');
            $table->decimal('exam_fee', 12, 2)->default(0)->after('book_fee');
            $table->decimal('received_amount', 12, 2)->default(0)->after('exam_fee');
            $table->decimal('balance_carried_forward', 12, 2)->default(0)->after('received_amount');
            $table->text('remarks')->nullable()->after('balance_carried_forward');
            $table->decimal('waived_off', 12, 2)->default(0)->after('remarks');
        });
    }

    public function down(): void
    {
        Schema::table('fees', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn([
                'parent_id',
                'payment_date',
                'copy_fee',
                'dress_fee',
                'book_fee',
                'exam_fee',
                'received_amount',
                'balance_carried_forward',
                'remarks',
                'waived_off',
            ]);
        });
    }
};
