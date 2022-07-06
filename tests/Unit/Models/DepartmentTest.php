<?php

namespace Tests\Unit\Models;

use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_department_has_a_name()
    {
        $department = Department::factory()->create();

        $this->assertnotNull($department->name);
    }
}
