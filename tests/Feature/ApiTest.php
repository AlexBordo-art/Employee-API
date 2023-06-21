<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Employee;
use App\Models\Transaction;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test employee creation.
     *
     * @return void
     */
    public function testCreateTransaction()
{
    $employee = Employee::factory()->create();

    $response = $this->postJson('/api/transactions', [
        'employee_id' => $employee->id,
        'hours_worked' => 8
    ]);

    $response->assertStatus(201);
    $this->assertDatabaseHas('transactions', [
        'employee_id' => $employee->id,
        'hours_worked' => 8
    ]);
}

public function testPaySalary()
{
    $employee = Employee::factory()->create();
    Transaction::factory()->create([
        'employee_id' => $employee->id,
        'hours_worked' => 2
    ]);

    $response = $this->postJson("/api/employees/{$employee->id}/pay");

    $response->assertStatus(200);
    $this->assertDatabaseHas('transactions', [
        'employee_id' => $employee->id,
        'is_paid' => true
    ]);
}

public function testUnpaidSalaries()
{
    $employee = Employee::factory()->create();
    Transaction::factory()->create([
        'employee_id' => $employee->id,
        'hours_worked' => 7
    ]);

    $response = $this->getJson('/api/transactions/unpaid');

    $response->assertStatus(200);
    $response->assertJson([
        $employee->id => $employee->hourly_rate * 7
    ]);
}
}