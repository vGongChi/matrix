<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FrontOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('product')
            ->orderByDesc('created_at')
            ->get();

        return view('order.index', compact('orders'));
    }

    public function create(Request $request)
    {
        $product = Product::published()->findOrFail($request->product_id);

        return view('order.create', compact('product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'requirements' => ['required', 'array'],
            'customer_notes' => ['nullable', 'string'],
        ]);

        $product = Product::published()->findOrFail($request->product_id);

        $order = Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'order_no' => Order::makeOrderNo(),
            'total_price' => $product->price,
            'deposit_amount' => round($product->price * ($product->deposit_rate / 100), 2),
            'final_amount' => round($product->price - round($product->price * ($product->deposit_rate / 100), 2), 2),
            'status' => 'pending_deposit',
            'requirements' => $request->requirements,
            'customer_notes' => $request->customer_notes,
            'remaining_revisions' => $product->max_revisions,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'redirect' => route('orders.show', $order->id),
            ]);
        }

        return redirect()->route('orders.show', $order->id);
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with('product')
            ->findOrFail($id);

        return view('order.show', compact('order'));
    }
}