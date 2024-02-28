<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        $action_icons = [
            "icon:pencil | color:yellow | click:redirect('/product/{id}')",
            "icon:trash | color:red | click:redirect('/delete/{id}')",
        ];

        return view('inventory', compact('products', 'action_icons'));
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
    public function store(StoreProductRequest $request)
    {
        $product = new Product;

        $product->name = $request->validated()['name'];
        $product->price = $request->validated()['price'];
        $product->stock = $request->validated()['stock'];

        $product->save();

        return redirect()->route('inventory')->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $product)
    {
        $product = Product::find($product);

        return view('product', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            // Add more validation rules as needed
        ]);

        $product->update($request->only('name', 'price', 'stock'));

        return redirect()->route('inventory')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $product)
    {
        Product::destroy($product);

        return redirect()->route('inventory');
    }

    public function purchase()
    {
        $products = Product::all();
        return view('purchase', compact('products'));
    }

    public function storePurchase(Request $request)
    {
        $request->validate([
            'product' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::find($request->product);

        $product->stock += $request->quantity;
        $product->save();

        $totalPrice = $product->price * $request->quantity;

        return redirect()->route('purchase.show')->with([
            'productName' => $product->name,
            'quantityPurchased' => $request->quantity,
            'productPrice' => $product->price,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function sales()
    {
        $products = Product::all();
        return view('sales', compact('products'));
    }

    public function storeSales(Request $request)
    {
        $request->validate([
            'product' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::find($request->product);

        if ($product->stock < $request->quantity) {
            return redirect()->back()->withErrors(['quantity' => 'Not enough stock for this product.']);
        }

        $product->stock -= $request->quantity;
        $product->save();

        $totalPrice = $product->price * $request->quantity;

        return redirect()->route('sales.show')->with([
            'productName' => $product->name,
            'quantitySold' => $request->quantity,
            'productPrice' => $product->price,
            'totalPrice' => $totalPrice,
        ]);
    }
}
