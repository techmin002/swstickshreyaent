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
        $customers = Customer::latest()->get();
        return view('backend.customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $image = '';
        if ($request->image) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/customer'), $image);
        }
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->description = $request->description;
        $customer->status = $request->has('status') ? 'on' : 'off';
        $customer->image = $image;
        $customer->save();

        return redirect()->back()->with('success', 'Customer created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $image = '';
        if ($request->image) {
            $image = time() . '.' . $request->image->extension();
            $request->image->move(public_path('upload/images/customer'), $image);
        }

        $customer = Customer::findOrFail($id);
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->description = $request->description;
        $customer->status = $request->has('status') ? 'on' : 'off';

        if ($request->image) {
            $customer->image = $image;
        }

        $customer->save();

        return redirect()->back()->with('success', 'Customer updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrfail($id);
        $customer->delete();
        return redirect()->back()->with('success', 'Customer Deleted!');
    }
    public function Status($id)
    {
        // dd($id);
        $customer = Customer::findOrfail($id);
        if ($customer->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $customer->update([
            'status' => $status
        ]);
        $customer->save();
        return redirect()->back()->with('success', 'Customer Status Updated!');
    }
}
