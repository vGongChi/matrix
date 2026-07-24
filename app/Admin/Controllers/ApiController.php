<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    public function products(Request $request)
    {
        $query = Product::query()->where('status', true);

        if ($request->get('q')) {
            $query->where('name', 'like', '%'.$request->get('q').'%');
        }

        $items = $query->limit(20)->get(['id', 'name']);

        return response()->json($items->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->name];
        }));
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->get('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->get('q').'%')
                    ->orWhere('email', 'like', '%'.$request->get('q').'%');
            });
        }

        $items = $query->limit(20)->get(['id', 'name', 'email']);

        return response()->json($items->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->name ?: $item->email];
        }));
    }

    public function orders(Request $request)
    {
        $query = Order::query();

        if ($request->get('q')) {
            $query->where('order_no', 'like', '%'.$request->get('q').'%');
        }

        $items = $query->limit(20)->get(['id', 'order_no']);

        return response()->json($items->map(function ($item) {
            return ['id' => $item->id, 'text' => $item->order_no];
        }));
    }
}
