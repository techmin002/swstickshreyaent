<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\StockCheckIn;
use Illuminate\Http\Request;

class StockCheckInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stockcheckins = StockCheckIn::with('product')->get();
        $products = Product::all();
        return view('backend.productstockin.index', compact('stockcheckins', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all(); // fetch all products
        return view('backend.productstockin.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $status = $request->has('status') ? 'on' : 'off';
        $total = $request->price * $request->quantity;

        // Always insert into stock_check_ins
        StockCheckIn::create([
            'product_id' => $request->product_id,
            'quantity'   => $request->quantity,
            'price'      => $request->price,
            'total'      => $total,
            'status'     => $status,
        ]);

        // Inventory logic9
        $inventory = Inventory::where('product_id', $request->product_id)->first();

        if ($inventory) {
            // dd('if');
            $inventory->opening_stock += $request->quantity;
            $inventory->closing_stock += $request->quantity;
            $inventory->save();
        } else {
            // dd($request->product_id);
            Inventory::create([
                'product_id' => $request->product_id,
                'opening_stock' => $request->quantity,
                'closing_stock' => $request->quantity,
                'status' => $status,
            ]);
        }

        return redirect()->route('inventory.index')->with('success', 'Stock checked in and inventory updated!');
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
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'price'      => 'required|numeric|min:0',
        ]);

        $stockCheckIn = StockCheckIn::findOrFail($id);

        // Calculate new total
        $status = $request->has('status') ? 'on' : 'off';
        $newTotal = $request->price * $request->quantity;

        // Adjust inventory before updating
        $inventory = Inventory::where('product_id', $stockCheckIn->product_id)->first();

        if ($inventory) {
            // Subtract old quantity from inventory
            $inventory->opening_stock -= $stockCheckIn->quantity;
            $inventory->closing_stock -= $stockCheckIn->quantity;

            // Add new quantity
            $inventory->opening_stock += $request->quantity;
            $inventory->closing_stock += $request->quantity;

            // Prevent negative stock
            $inventory->opening_stock = max(0, $inventory->opening_stock);
            $inventory->closing_stock = max(0, $inventory->closing_stock);

            $inventory->save();
        }

        // Update stock check-in record
        $stockCheckIn->update([
            'product_id' => $request->product_id,
            'quantity'   => $request->quantity,
            'price'      => $request->price,
            'total'      => $newTotal,
            'status'     => $status,
        ]);

        return redirect()->route('stockin.index')->with('success', 'Stock check-in updated and inventory adjusted!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $checkin = StockCheckIn::findOrFail($id);

        $inventory = Inventory::where('product_id', $checkin->product_id)->first();

        if ($inventory) {
            $inventory->opening_stock -= $checkin->quantity;
            $inventory->closing_stock -= $checkin->quantity;

            // Don't let it go negative
            $inventory->opening_stock = max(0, $inventory->opening_stock);
            $inventory->closing_stock = max(0, $inventory->closing_stock);

            $inventory->save();
        }

        $checkin->delete();

        return redirect()->route('stockin.index')->with('success', 'Stock Check-in deleted and inventory updated.');
    }


    // public function Status($id)
    // {
    //     $stock = StockCheckIn::findOrFail($id);
    //     $stock->status = $stock->status === 'on' ? 'off' : 'on';
    //     $stock->save();

    //     return redirect()->back()->with('success', 'Status Updated!');
    // }
    public function Status($id)
    {
        $stock = StockCheckIn::findOrFail($id);

        // Toggle stock status
        $stock->status = $stock->status === 'on' ? 'off' : 'on';

        // Find related inventory
        $inventory = Inventory::where('product_id', $stock->product_id)->first();

        if ($inventory) {
            // Just toggle the status without changing stock numbers
            $inventory->status = $stock->status;
            $inventory->save();
        }

        $stock->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
