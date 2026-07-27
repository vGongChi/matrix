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

    public function updateRequirements(Request $request, $id)
    {
        $order = Order::where('user_id', Auth::id())
            ->findOrFail($id);

        if (! empty($order->deposit_paid) || $order->status !== 'pending_deposit') {
            return redirect()->route('orders.show', $order->id)
                ->with('error', '启动金已支付后，需求信息将无法继续修改。');
        }

        $data = $request->validate([
            'requirements' => ['required', 'string', 'max:4000'],
            'customer_notes' => ['nullable', 'string', 'max:4000'],
        ]);

        $requirements = trim($data['requirements']);

        $order->update([
            'requirements' => ! empty($requirements)
                ? [[
                    'type' => 'description',
                    'content' => $requirements,
                ]]
                : [],
            'customer_notes' => $data['customer_notes'] ?? null,
        ]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', '需求信息已更新。');
    }

    public function payDeposit($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->findOrFail($id);

        if (! empty($order->deposit_paid)) {
            return redirect()->route('orders.show', $order->id)
                ->with('success', '启动金已经支付完成。');
        }

        if ($order->status !== 'pending_deposit') {
            return redirect()->route('orders.show', $order->id)
                ->with('error', '当前订单状态不支持支付启动金。');
        }

        $order->update([
            'deposit_paid' => true,
            'deposit_paid_at' => now(),
            'status' => 'processing',
        ]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', '启动金支付成功，订单已进入制作流程。');
    }
}