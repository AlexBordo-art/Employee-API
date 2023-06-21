<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Transaction;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function store(Request $request)
{
    $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'hours_worked' => 'required|integer|min:1',
    ]);

    $transaction = new Transaction;
    $transaction->employee_id = $request->employee_id;
    $transaction->hours_worked = $request->hours_worked;
    $transaction->save();

    return response()->json(['message' => 'Transaction created successfully', 'transaction' => $transaction], 201);
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

    public function unpaid()
{
    $employees = Employee::all();
    $unpaidSalaries = [];

    foreach ($employees as $employee) {
        $unpaidHours = $employee->transactions()->where('is_paid', false)->sum('hours_worked');
        $unpaidSalaries[$employee->id] = $unpaidHours * $employee->hourly_rate;
    }

    return response()->json($unpaidSalaries, 200);
}



}
