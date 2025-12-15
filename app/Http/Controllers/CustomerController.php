<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Customer;
use Inertia\Inertia;

class CustomerController extends Controller
{
    // Show Customers List with per page 10 list pagination
    function index() {
        return Inertia::render('Customers/Index', [
            'customers' => Customer::where('is_deleted', 0)->paginate(10)
        ]);
    }

    // Show Create Customer Form
    function create() {
        return Inertia::render('Customers/Create');
    }

    // Store Customer
    function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'max:255|unique:customers,email',
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'is_deleted' => 'required|in:0,1',
        ]);

        Customer::create($request->all());

        return redirect()->route('invoices.create');
    }

    // Show Edit Customer Form
    function edit($id) {
        $customer = Customer::findOrFail($id);
        return Inertia::render('Customers/Edit', [
            'customer' => $customer
        ]);
    }

    // Update Customer
    function update(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'email' => 'max:255|unique:customers,email,' . $id,
            'phone' => 'required|string',
            'address' => 'nullable|string',
            'status' => 'required|in:Active,Inactive',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return redirect()->route('customers.index');
    }

    // Delete Customer
    function destroy($id) {
        $customer = Customer::findOrFail($id);
        $customer->update([
            'is_deleted' => 1
            ]);

        return redirect()->route('customers.index');
    }
}