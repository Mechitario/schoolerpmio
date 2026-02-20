<?php

namespace Database\Seeders;

use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Database\Seeder;

class ParentPortalSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        
        if ($students->isEmpty()) {
            $this->command->warn('No students found. Please seed students first.');
            return;
        }

        $additionalParents = [
            ['name' => 'Ramesh Kumar', 'email' => 'ramesh.kumar@example.com', 'phone' => '9876543225', 'address' => 'Sector 15, Noida, UP', 'password' => 'password'],
            ['name' => 'Sunita Devi', 'email' => 'sunita.devi@example.com', 'phone' => '9876543226', 'address' => 'Sector 25, Noida, UP', 'password' => 'password'],
            ['name' => 'Amitabh Singh', 'email' => 'amitabh.singh@example.com', 'phone' => '9876543227', 'address' => 'Sector 35, Noida, UP', 'password' => 'password'],
            ['name' => 'Priya Sharma', 'email' => 'priya.sharma@example.com', 'phone' => '9876543228', 'address' => 'Sector 45, Noida, UP', 'password' => 'password'],
            ['name' => 'Vikash Patel', 'email' => 'vikash.patel@example.com', 'phone' => '9876543229', 'address' => 'Sector 55, Noida, UP', 'password' => 'password'],
            ['name' => 'Meera Joshi', 'email' => 'meera.joshi@example.com', 'phone' => '9876543230', 'address' => 'Sector 65, Noida, UP', 'password' => 'password'],
            ['name' => 'Suresh Kumar', 'email' => 'suresh.kumar@example.com', 'phone' => '9876543231', 'address' => 'Sector 75, Noida, UP', 'password' => 'password'],
            ['name' => 'Anita Reddy', 'email' => 'anita.reddy@example.com', 'phone' => '9876543232', 'address' => 'Sector 85, Noida, UP', 'password' => 'password'],
            ['name' => 'Rajesh Iyer', 'email' => 'rajesh.iyer@example.com', 'phone' => '9876543233', 'address' => 'Sector 95, Noida, UP', 'password' => 'password'],
            ['name' => 'Kavita Nair', 'email' => 'kavita.nair@example.com', 'phone' => '9876543234', 'address' => 'Sector 105, Noida, UP', 'password' => 'password'],
        ];

        $studentIds = $students->pluck('id')->toArray();
        $usedStudentIds = [];

        foreach ($additionalParents as $p) {
            // Check if parent already exists
            $existing = Guardian::where('email', $p['email'])->first();
            if ($existing) {
                // Update password if not set
                if (!$existing->password) {
                    $existing->password = $p['password'];
                    $existing->save();
                }
                continue;
            }

            $parent = Guardian::create($p);
            
            // Link 1-3 random students to this parent
            $count = rand(1, 3);
            $available = array_values(array_diff($studentIds, $usedStudentIds));
            
            if (count($available) > 0) {
                $pick = min($count, count($available));
                $indices = array_rand($available, $pick);
                if (!is_array($indices)) {
                    $indices = [$indices];
                }
                
                foreach ($indices as $idx) {
                    $sid = $available[$idx];
                    $usedStudentIds[] = $sid;
                    Student::where('id', $sid)->update(['parent_id' => $parent->id]);
                }
            }
        }

        // Ensure all existing parents have passwords
        $parentsWithoutPassword = Guardian::whereNull('password')->whereNotNull('email')->get();
        foreach ($parentsWithoutPassword as $parent) {
            $parent->password = 'password';
            $parent->save();
        }

        $this->command->info('Successfully created/updated parent portal accounts!');
        $this->command->info('All parents with email addresses now have login credentials.');
        $this->command->info('Default password for all parents: password');
    }
}
