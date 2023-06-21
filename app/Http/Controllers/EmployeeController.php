<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:employees',
            'password' => 'required|min:8',
            'hourly_rate' => 'required|numeric|min:0', 
        ]);

        $employee = new Employee;
        $employee->email = $request->email;
        $employee->password = Hash::make($request->password);
        $employee->hourly_rate = $request->hourly_rate;
        $employee->save();

        return response()->json(['message' => 'Employee created successfully', 'employee' => $employee], 201);
    }

    public function pay(Request $request, $id)
{
    $employee = Employee::find($id);

    if (!$employee) {
        return response()->json(['message' => 'Employee not found'], 404);
    }

    $transactions = $employee->transactions()->where('is_paid', false)->get();

    $totalSalary = 0;

    foreach ($transactions as $transaction) {
        $transaction->is_paid = true;
        $transaction->save();
        $totalSalary += $transaction->hours * $employee->hourly_rate;
    }

    return response()->json(['message' => 'Salary paid successfully to employee', 'totalSalary' => $totalSalary], 200);
}


}
