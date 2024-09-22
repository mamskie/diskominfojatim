<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
{
    $orders = Order::with(['products' => function ($query) {
        $query->select('products.id', 'products.name', 'products.price', 'products.stock', 'products.sold', 'order_product.quantity', 'products.created_at', 'products.updated_at');
    }])->get()->map(function ($order) {
        return [
            'id' => $order->id,
            'products' => $order->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $product->pivot->quantity,
                    'stock' => $product->stock,
                    'sold' => $product->sold,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                ];
            }),
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
        ];
    });

    return response()->json([
        'message' => 'Order List',
        'data' => $orders
    ], 200);
}
    
    public function store(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create();

        foreach ($request->products as $product) {
            $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        return response()->json([
            'message' => 'Order created',
            'data' => $order->load('products')
        ], 200);
    }

    public function show($id)
{
    $order = Order::with('products')->find($id);

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    $products = $order->products->map(function ($product) {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $product->pivot->quantity, 
            'stock' => $product->stock,
            'sold' => $product->sold,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ];
    });

    return response()->json([
        'message' => 'Order Detail',
        'data' => [
            'id' => $order->id,
            'products' => $products,
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
        ]
    ], 200);
}

    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json([
            'message' => 'Order deleted successfully',
            'data' => $order
        ], 200);
    }
}