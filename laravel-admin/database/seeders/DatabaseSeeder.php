<?php

namespace Database\Seeders;

use App\Models\Fee;
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
            ['name' => 'Admin', 'password' => 'password']
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
        $studentIds = Student::pluck('id')->toArray();
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $statuses = ['PAID', 'PAID', 'PAID', 'PENDING', 'PARTIAL'];

        for ($i = 0; $i < 80; $i++) {
            $status = $statuses[array_rand($statuses)];
            Fee::create([
                'student_id' => $studentIds[array_rand($studentIds)],
                'amount' => rand(300, 650),
                'status' => $status,
                'month' => $months[array_rand($months)],
                'paid_date' => in_array($status, ['PAID', 'PARTIAL']) && rand(0, 1) ? now()->subDays(rand(1, 90)) : null,
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
