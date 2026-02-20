<?php

namespace Database\Seeders;

use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Database\Seeder;

class ParentSeeder extends Seeder
{
    public function run(): void
    {
        $parentsData = [
            ['name' => 'Rajesh Kumar Verma', 'email' => 'rajesh.verma@example.com', 'phone' => '9876543210', 'address' => 'Sector 115, Noida, UP'],
            ['name' => 'Sunita Singh', 'email' => 'sunita.singh@example.com', 'phone' => '9876543211', 'address' => 'Sector 50, Noida, UP'],
            ['name' => 'Manoj Dev', 'email' => 'manoj.dev@example.com', 'phone' => '9876543212', 'address' => 'Sector 62, Noida, UP'],
            ['name' => 'Kavita Kaur', 'email' => 'kavita.kaur@example.com', 'phone' => '9876543213', 'address' => 'Sector 18, Noida, UP'],
            ['name' => 'Amit Gupta', 'email' => 'amit.gupta@example.com', 'phone' => '9876543214', 'address' => 'Sector 22, Noida, UP'],
            ['name' => 'Pooja Ray', 'email' => 'pooja.ray@example.com', 'phone' => '9876543215', 'address' => 'Sector 44, Noida, UP'],
            ['name' => 'Vikram Sharma', 'email' => 'vikram.sharma@example.com', 'phone' => '9876543216', 'address' => 'Sector 34, Noida, UP'],
            ['name' => 'Anita Patel', 'email' => 'anita.patel@example.com', 'phone' => '9876543217', 'address' => 'Sector 51, Noida, UP'],
            ['name' => 'Suresh Reddy', 'email' => 'suresh.reddy@example.com', 'phone' => '9876543218', 'address' => 'Sector 120, Noida, UP'],
            ['name' => 'Lakshmi Iyer', 'email' => 'lakshmi.iyer@example.com', 'phone' => '9876543219', 'address' => 'Sector 76, Noida, UP'],
            ['name' => 'Ramesh Nair', 'email' => 'ramesh.nair@example.com', 'phone' => '9876543220', 'address' => 'Sector 93, Noida, UP'],
            ['name' => 'Deepa Menon', 'email' => 'deepa.menon@example.com', 'phone' => '9876543221', 'address' => 'Sector 49, Noida, UP'],
            ['name' => 'Sanjay Krishnan', 'email' => 'sanjay.k@example.com', 'phone' => '9876543222', 'address' => 'Sector 71, Noida, UP'],
            ['name' => 'Neha Malhotra', 'email' => 'neha.malhotra@example.com', 'phone' => '9876543223', 'address' => 'Sector 28, Noida, UP'],
            ['name' => 'Ravi Desai', 'email' => 'ravi.desai@example.com', 'phone' => '9876543224', 'address' => 'Sector 117, Noida, UP'],
        ];

        $studentIds = Student::pluck('id')->toArray();
        $usedStudentIds = [];

        foreach ($parentsData as $p) {
            $parent = Guardian::firstOrCreate(
                ['email' => $p['email']],
                ['name' => $p['name'], 'phone' => $p['phone'], 'address' => $p['address']]
            );
            $count = rand(1, 3);
            $available = array_values(array_diff($studentIds, $usedStudentIds));
            if (count($available) > 0) {
                $pick = min($count, count($available));
                $indices = array_rand($available, $pick);
                if (! is_array($indices)) {
                    $indices = [$indices];
                }
                foreach ($indices as $idx) {
                    $sid = $available[$idx];
                    $usedStudentIds[] = $sid;
                    Student::where('id', $sid)->update(['parent_id' => $parent->id]);
                }
            }
        }
    }
}
