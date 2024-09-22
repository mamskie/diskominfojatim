<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index()
    {
    $products = Product::all();

    if ($products->isEmpty()) {
        return response()->json([
            'message' => 'No products found',
            'data' => []
        ], 200);
    }

    return response()->json([
        'message' => 'Product List',
        'data' => $products
    ], 200);
    }
    
    public function store(Request $request)
    {
    $validatedData = $request->validate([
        'name'  => 'required|unique:products,name',
        'price' => 'required|integer|min:1',
        'stock' => 'required|integer'
    ]);

    $product = Product::create($validatedData + ['sold' => 0]);

    return response()->json([
        'message' => 'Product created successfully',
        'data'    => $product
    ], 200);
    }
    
    public function show($id)
    {
    $product = Product::find($id);

    if (!$product) {
        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }

    return response()->json([
        'message' => 'Product Details',
        'data'    => $product
    ], 200);
    }
    
    public function update(Request $request, $id)
    {
    $product = Product::find($id);

    if (!$product) {
        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }

    $validatedData = $request->validate([
        'name'  => 'sometimes|required|unique:products,name,' . $id,
        'price' => 'sometimes|required|integer|min:1',
        'stock' => 'sometimes|required|integer'
    ]);

    $product->update($validatedData);

    return response()->json([
        'message' => 'Product updated successfully',
        'data'    => $product
    ], 200);
    }
    
    public function destroy($id)
    {
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }
    
        $product->delete();
    
        return response()->json([
            'message' => 'Product deleted successfully',
            'data'    => $product
        ], 200);
    }
}