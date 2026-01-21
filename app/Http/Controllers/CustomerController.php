<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::paginate(20);
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Customer::create([
            'name' => $request->name,
            'kana' => $request->kana,
            'email' => $request->email,
            'phone' => $request->phone,
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'address_detail' => $request->address_detail,
            'company_name' => $request->company_name,
            'department' => $request->department,
            'position' => $request->position,
            'status' => $request->status,
            'rank' => $request->rank,
            'assigned_user_id' => $request->assigned_user_id,
            'memo' => $request->memo,
        ]);
        return redirect()->route('customers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
