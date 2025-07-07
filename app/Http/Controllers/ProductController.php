<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('backend.product.index', compact('products'));
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
        Product::create([
            'name' => $request['name'],
            'status' => $request->has('status') ? 'on' : 'off',
        ]);

        // ✅ Redirect or return
        return redirect()->back()->with('success', 'Product added successfully!');
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
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'status' => $request->has('status') ? 'on' : 'off',
        ]);

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // dd($id);
        $product = Product::findOrfail($id);
        $product->delete();
        return redirect()->back()->with('success', 'Product Deleted!');
    }

    public function Status($id)
    {
        // dd($id);
        $product = Product::findOrfail($id);
        if ($product->status == 'on') {
            $status = 'off';
        } else {
            $status = 'on';
        }
        $product->update([
            'status' => $status
        ]);
        return redirect()->back()->with('success', 'Product Status Updated!');
    }
}
