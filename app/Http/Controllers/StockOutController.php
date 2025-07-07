<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\StockCheckIn;
use App\Models\StockOut;
use App\Models\StockOutProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StockOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stockOuts = StockOut::with('customer')->latest()->get();
        return view('backend.productstockout.index', compact('stockOuts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // In StockOutController
    public function create()
    {
        $customers = Customer::all();

        // Get latest StockCheckIn per product (optional: group by product)
        $stockCheckIns = StockCheckIn::with('product')
            ->select('product_id', 'price')
            ->groupBy('product_id', 'price')
            ->get()
            ->map(function ($stock) {
                return [
                    'product_id' => $stock->product_id,
                    'product_name' => $stock->product->name,
                    'price' => $stock->price,
                ];
            });

        return view('backend.productstockout.create', compact('customers', 'stockCheckIns'));
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Check all inventory quantities first
            foreach ($request->products as $item) {
                $inventory = Inventory::where('product_id', $item['product_id'])->first();
                $product = Product::find($item['product_id']);
                if (!$inventory || $inventory->closing_stock < $item['quantity']) {
                    throw new \Exception("Insufficient stock for product: " . ($product->name ?? 'Unknown'));
                }
            }

            // Create main stock out record
            $stockOut = StockOut::create([
                'customer_id' => $request->customer_id,
                'total' => $request->total,
            ]);

            // Save each product and update inventory
            foreach ($request->products as $item) {
                $quantity = $item['quantity'];
                $price = $item['price'];
                $total = $quantity * $price;

                // Create stock out product record
                StockOutProduct::create([
                    'stock_out_id' => $stockOut->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $total,
                ]);

                // Decrease closing_stock in Inventory
                Inventory::where('product_id', $item['product_id'])
                    ->decrement('closing_stock', $quantity);
            }

            DB::commit();

            return redirect()->route('stockout.index')->with('success', 'Stock out recorded and inventory updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $stockOut = StockOut::with(['customer', 'products.product'])->findOrFail($id);
        return view('backend.productstockout.details', compact('stockOut'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
