<?php

namespace Database\Seeders;

use App\Models\Guardian;
use Illuminate\Database\Seeder;

class UpdateParentPasswordsSeeder extends Seeder
{
    public function run(): void
    {
        $parents = Guardian::whereNull('password')->get();
        
        foreach ($parents as $parent) {
            $parent->password = 'password';
            $parent->save();
        }
        
        $this->command->info("Updated {$parents->count()} parents with default password 'password'.");
    }
}
