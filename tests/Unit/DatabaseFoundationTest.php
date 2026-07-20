<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Models\Department;
use App\Models\Project;

class DatabaseFoundationTest extends TestCase
{
    public function test_user_full_name_attribute()
    {
        $user = new User(['first_name' => 'Ahmed', 'last_name' => 'Olanrewaju']);
        $this->assertEquals('Ahmed Olanrewaju', $user->full_name);
    }

    public function test_department_relationship_definition()
    {
        $dept = new Department(['code' => 'ICT', 'name' => 'ICT Unit']);
        $this->assertTrue(method_exists($dept, 'users'));
    }

    public function test_project_budget_casting()
    {
        $project = new Project(['budget' => 1500000.50]);
        $this->assertIsNumeric($project->budget);
    }
}
