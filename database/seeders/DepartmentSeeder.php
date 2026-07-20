<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $depts = [
            ['code' => 'NPCO', 'name' => 'National Programme Coordination Office'],
            ['code' => 'ICT', 'name' => 'Information & Communication Technology Unit'],
            ['code' => 'ME', 'name' => 'Monitoring & Evaluation Unit'],
            ['code' => 'PROC', 'name' => 'Procurement & Finance Department'],
        ];

        foreach ($depts as $d) {
            Department::firstOrCreate(['code' => $d['code']], ['name' => $d['name']]);
        }
    }
}
