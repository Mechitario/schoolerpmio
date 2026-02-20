<?php

namespace Database\Seeders;

use App\Models\Fee;
use App\Models\Student;
use Illuminate\Database\Seeder;

class FeeSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing fees if needed (optional - comment out if you want to keep existing data)
        // Fee::truncate();

        $students = Student::with('parent')->get();
        
        if ($students->isEmpty()) {
            $this->command->warn('No students found. Please seed students first.');
            return;
        }
        
        $months = [
            'January 2025', 'February 2025', 'March 2025', 'April 2025', 
            'May 2025', 'June 2025', 'July 2025', 'August 2025', 
            'September 2025', 'October 2025', 'November 2025', 'December 2025'
        ];
        
        $remarks = [
            'Regular payment',
            'Partial payment received',
            'Full payment',
            'Payment via bank transfer',
            'Cash payment',
            'Payment with waiver',
            'Balance carried forward',
            'Early bird discount applied',
            'Scholarship student',
            null,
            null,
            null,
        ];

        $this->command->info('Creating fee records with correct calculations...');

        // Create fees for different scenarios
        for ($i = 0; $i < 100; $i++) {
            $student = $students->random();
            
            // Generate fee components
            $copyFee = rand(50, 150);
            $dressFee = rand(200, 400);
            $bookFee = rand(300, 600);
            $examFee = rand(100, 300);
            $total = $copyFee + $dressFee + $bookFee + $examFee;
            
            // Determine payment scenario
            $scenario = rand(1, 10);
            
            $paidAmount = 0;
            $waivedOff = 0;
            $balanceCarriedForward = 0;
            $paymentDate = null;
            
            if ($scenario <= 4) {
                // Fully paid (40% chance)
                $paidAmount = $total;
                $paymentDate = now()->subDays(rand(1, 90));
            } elseif ($scenario <= 7) {
                // Partially paid (30% chance)
                $paidAmount = rand((int)($total * 0.3), (int)($total * 0.8));
                $paymentDate = now()->subDays(rand(1, 90));
            } elseif ($scenario <= 9) {
                // Pending (20% chance)
                $paidAmount = 0;
                $paymentDate = null;
            } else {
                // Partially paid with waiver (10% chance)
                $paidAmount = rand((int)($total * 0.4), (int)($total * 0.7));
                $waivedOff = rand(50, min(200, $total - $paidAmount));
                $paymentDate = now()->subDays(rand(1, 90));
            }
            
            // Calculate balance carried forward (sometimes)
            if (rand(1, 5) === 1 && $paidAmount < $total) {
                $balanceCarriedForward = rand(50, min(200, $total - $paidAmount));
            }
            
            // received_amount = paid_amount
            $receivedAmount = $paidAmount;
            
            Fee::create([
                'student_id' => $student->id,
                'parent_id' => $student->parent_id,
                'copy_fee' => $copyFee,
                'dress_fee' => $dressFee,
                'book_fee' => $bookFee,
                'exam_fee' => $examFee,
                'amount' => $total,
                'received_amount' => $receivedAmount,
                'paid_amount' => $paidAmount,
                'waived_off' => $waivedOff,
                'balance_carried_forward' => $balanceCarriedForward,
                'month' => $months[array_rand($months)],
                'payment_date' => $paymentDate,
                'remarks' => $remarks[array_rand($remarks)],
                // Status will be calculated automatically by the model's booted() method
            ]);
        }

        $this->command->info('Successfully created 100 fee records with correct calculations!');
    }
}
