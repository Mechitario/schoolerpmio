<?php

namespace Database\Seeders;

use App\Models\Fee;
use App\Models\Guardian;
use App\Models\Result;
use App\Models\Salary;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedAdmin();
        $this->seedStudents();
        $this->seedParents();
        $this->seedStaff();
        $this->seedFees();
        $this->seedResults();
        $this->seedSalaries();
        $this->seedTransactions();
    }

    private function seedAdmin(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@school.com'],
            [
                'name' => 'Admin',
                'password' => 'password',
                'role' => 'admin',
                'can_view_dashboard' => true,
                'can_view_admin_users' => true,
                'can_view_students' => true,
                'can_view_parents' => true,
                'can_view_staff' => true,
                'can_view_fees' => true,
                'can_view_inventory' => true,
                'can_view_academics' => true,
            ]
        );
    }

    private function seedStudents(): void
    {
        $classes = ['9th', '10th', '11th', '12th'];
        $sections = ['A', 'B', 'C'];
        $names = [
            'Arjun Verma', 'Priya Singh', 'Rahul Dev', 'Simran Kaur', 'Aman Gupta', 'Lisa Ray',
            'Vikram Singh', 'Anjali Sharma', 'Rohan Patel', 'Kavita Reddy', 'Suresh Kumar', 'Meera Iyer',
            'Aditya Joshi', 'Pooja Nair', 'Ravi Menon', 'Divya Krishnan', 'Karan Malhotra', 'Neha Kapoor',
            'Rahul Bhatia', 'Shreya Desai', 'Arun Pillai', 'Swati Rao', 'Nikhil Choudhury', 'Preeti Saxena',
            'Varun Agarwal', 'Kriti Banerjee', 'Siddharth Das', 'Ananya Ghosh', 'Rishabh Mukherjee', 'Ishita Chatterjee',
            'Akash Dutta', 'Tanvi Roy', 'Harsh Sinha', 'Riya Verma', 'Yash Tiwari', 'Aisha Khan',
            'Rohan Mehta', 'Zara Ali', 'Vivek Shah', 'Sana Hussain', 'Kunal Pandey', 'Fatima Sheikh',
            'Rajat Gupta', 'Naina Singh', 'Abhishek Yadav', 'Diya Patel', 'Mohit Sharma', 'Aarav Reddy',
        ];

        $roll = 100;
        foreach ($names as $name) {
            $class = $classes[array_rand($classes)];
            $section = $sections[array_rand($sections)];
            Student::create([
                'name' => $name,
                'roll_number' => (string) (++$roll),
                'class_name' => $class,
                'section' => $section,
            ]);
        }
    }

    private function seedParents(): void
    {
        $parentsData = [
            ['name' => 'Rajesh Kumar Verma', 'email' => 'rajesh.verma@example.com', 'phone' => '9876543210', 'address' => 'Sector 115, Noida, UP', 'password' => 'password'],
            ['name' => 'Sunita Singh', 'email' => 'sunita.singh@example.com', 'phone' => '9876543211', 'address' => 'Sector 50, Noida, UP', 'password' => 'password'],
            ['name' => 'Manoj Dev', 'email' => 'manoj.dev@example.com', 'phone' => '9876543212', 'address' => 'Sector 62, Noida, UP', 'password' => 'password'],
            ['name' => 'Kavita Kaur', 'email' => 'kavita.kaur@example.com', 'phone' => '9876543213', 'address' => 'Sector 18, Noida, UP', 'password' => 'password'],
            ['name' => 'Amit Gupta', 'email' => 'amit.gupta@example.com', 'phone' => '9876543214', 'address' => 'Sector 22, Noida, UP', 'password' => 'password'],
            ['name' => 'Pooja Ray', 'email' => 'pooja.ray@example.com', 'phone' => '9876543215', 'address' => 'Sector 44, Noida, UP', 'password' => 'password'],
            ['name' => 'Vikram Sharma', 'email' => 'vikram.sharma@example.com', 'phone' => '9876543216', 'address' => 'Sector 34, Noida, UP', 'password' => 'password'],
            ['name' => 'Anita Patel', 'email' => 'anita.patel@example.com', 'phone' => '9876543217', 'address' => 'Sector 51, Noida, UP', 'password' => 'password'],
            ['name' => 'Suresh Reddy', 'email' => 'suresh.reddy@example.com', 'phone' => '9876543218', 'address' => 'Sector 120, Noida, UP', 'password' => 'password'],
            ['name' => 'Lakshmi Iyer', 'email' => 'lakshmi.iyer@example.com', 'phone' => '9876543219', 'address' => 'Sector 76, Noida, UP', 'password' => 'password'],
            ['name' => 'Ramesh Nair', 'email' => 'ramesh.nair@example.com', 'phone' => '9876543220', 'address' => 'Sector 93, Noida, UP', 'password' => 'password'],
            ['name' => 'Deepa Menon', 'email' => 'deepa.menon@example.com', 'phone' => '9876543221', 'address' => 'Sector 49, Noida, UP', 'password' => 'password'],
            ['name' => 'Sanjay Krishnan', 'email' => 'sanjay.k@example.com', 'phone' => '9876543222', 'address' => 'Sector 71, Noida, UP', 'password' => 'password'],
            ['name' => 'Neha Malhotra', 'email' => 'neha.malhotra@example.com', 'phone' => '9876543223', 'address' => 'Sector 28, Noida, UP', 'password' => 'password'],
            ['name' => 'Ravi Desai', 'email' => 'ravi.desai@example.com', 'phone' => '9876543224', 'address' => 'Sector 117, Noida, UP', 'password' => 'password'],
        ];

        $studentIds = Student::pluck('id')->toArray();
        $usedStudentIds = [];
        $parentIds = [];

        foreach ($parentsData as $p) {
            $password = $p['password'];
            unset($p['password']);
            $parent = Guardian::create($p);
            $parent->password = $password;
            $parent->save();
            $parentIds[] = $parent->id;
            $count = rand(1, 3);
            $available = array_diff($studentIds, $usedStudentIds);
            $available = array_values($available);
            if (count($available) > 0) {
                $pick = min($count, count($available));
                $chosen = array_rand(array_flip($available), $pick);
                if (! is_array($chosen)) {
                    $chosen = [$chosen];
                }
                foreach ($chosen as $sid) {
                    $usedStudentIds[] = $sid;
                    Student::where('id', $sid)->update(['parent_id' => $parent->id]);
                }
            }
        }
    }

    private function seedStaff(): void
    {
        $staffList = [
            ['name' => 'Dr. Ramesh Kumar', 'role' => 'Principal', 'salary' => 5500],
            ['name' => 'Mrs. Kavita Nair', 'role' => 'Vice Principal', 'salary' => 4200],
            ['name' => 'Ms. Anita Sharma', 'role' => 'Senior Teacher', 'salary' => 3200],
            ['name' => 'Mr. Sunil Gupta', 'role' => 'Accountant', 'salary' => 2800],
            ['name' => 'Ms. Deepa Rani', 'role' => 'Teacher', 'salary' => 2500],
            ['name' => 'Mr. Vikram Singh', 'role' => 'PE Teacher', 'salary' => 2400],
            ['name' => 'Dr. Priya Menon', 'role' => 'Science HOD', 'salary' => 3800],
            ['name' => 'Mr. Suresh Iyer', 'role' => 'Mathematics Teacher', 'salary' => 2600],
            ['name' => 'Ms. Lakshmi Rao', 'role' => 'English Teacher', 'salary' => 2550],
            ['name' => 'Mr. Rajesh Pillai', 'role' => 'Hindi Teacher', 'salary' => 2450],
            ['name' => 'Ms. Geeta Nair', 'role' => 'Librarian', 'salary' => 2200],
            ['name' => 'Mr. Arun Kumar', 'role' => 'Lab Assistant', 'salary' => 1800],
            ['name' => 'Ms. Rekha Desai', 'role' => 'Admin Officer', 'salary' => 2300],
            ['name' => 'Mr. Manoj Reddy', 'role' => 'Security Incharge', 'salary' => 2000],
            ['name' => 'Ms. Sunita Joshi', 'role' => 'Counselor', 'salary' => 2700],
        ];

        foreach ($staffList as $s) {
            Staff::create($s);
        }
    }

    private function seedFees(): void
    {
        $students = Student::with('parent')->get();
        
        if ($students->isEmpty()) {
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

        // Create fees for different scenarios
        for ($i = 0; $i < 80; $i++) {
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
    }

    private function seedResults(): void
    {
        $subjects = ['Mathematics', 'Science', 'English', 'Hindi', 'Social Studies', 'Computer'];
        $examNames = ['Mid-Term 2025', 'Final 2025'];

        foreach (Student::all() as $student) {
            foreach ($examNames as $examName) {
                foreach ($subjects as $subject) {
                    $total = 100;
                    $marks = rand(55, 98);
                    Result::create([
                        'student_id' => $student->id,
                        'subject' => $subject,
                        'marks' => $marks,
                        'total_marks' => $total,
                        'exam_name' => $examName,
                    ]);
                }
            }
        }
    }

    private function seedSalaries(): void
    {
        $staffIds = Staff::pluck('id')->toArray();
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        foreach (Staff::all() as $staff) {
            foreach (array_slice($months, 0, rand(3, 6)) as $month) {
                Salary::create([
                    'staff_id' => $staff->id,
                    'amount' => $staff->salary,
                    'month' => $month,
                    'paid_date' => now()->subMonths(rand(0, 5)),
                ]);
            }
        }
    }

    private function seedTransactions(): void
    {
        $incomes = [
            ['type' => 'INCOME', 'amount' => 125000, 'description' => 'Monthly fee collection'],
            ['type' => 'INCOME', 'amount' => 45000, 'description' => 'Transport fees'],
            ['type' => 'INCOME', 'amount' => 12000, 'description' => 'Library fine / misc'],
            ['type' => 'INCOME', 'amount' => 8000, 'description' => 'Event registration'],
            ['type' => 'INCOME', 'amount' => 32000, 'description' => 'Admission fees'],
            ['type' => 'INCOME', 'amount' => 98000, 'description' => 'Monthly fee collection'],
            ['type' => 'INCOME', 'amount' => 41000, 'description' => 'Transport fees'],
            ['type' => 'INCOME', 'amount' => 15000, 'description' => 'Donation'],
        ];

        $expenses = [
            ['type' => 'EXPENSE', 'amount' => 85000, 'description' => 'Staff salaries'],
            ['type' => 'EXPENSE', 'amount' => 12000, 'description' => 'Electricity and utilities'],
            ['type' => 'EXPENSE', 'amount' => 8000, 'description' => 'Stationery and books'],
            ['type' => 'EXPENSE', 'amount' => 15000, 'description' => 'Maintenance and repairs'],
            ['type' => 'EXPENSE', 'amount' => 5000, 'description' => 'Sports equipment'],
            ['type' => 'EXPENSE', 'amount' => 78000, 'description' => 'Staff salaries'],
            ['type' => 'EXPENSE', 'amount' => 11000, 'description' => 'Electricity and utilities'],
            ['type' => 'EXPENSE', 'amount' => 6000, 'description' => 'Cleaning and hygiene'],
        ];

        foreach (array_merge($incomes, $expenses) as $t) {
            Transaction::create([
                'type' => $t['type'],
                'amount' => $t['amount'],
                'description' => $t['description'],
                'date' => now()->subDays(rand(1, 60)),
            ]);
        }
    }
}
