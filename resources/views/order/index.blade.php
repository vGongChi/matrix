@extends('layouts.app')

@section('title', '我的订单')
@section('meta_description', '查看我的订单列表与项目进度。')

@section('content')
    @include('partials.header')

    <main class="min-h-screen bg-slate-50 px-4 py-12 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-6xl">
            <div class="rounded-3xl bg-white p-8 shadow-lg shadow-slate-200/50">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-primary">我的订单</p>
                        <h1 class="mt-3 text-3xl font-bold text-slate-950">订单列表</h1>
                        <p class="mt-2 text-sm text-slate-500">查看你提交的项目需求、当前状态与后续进度。</p>
                    </div>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-primary hover:text-primary">继续下单</a>
                </div>

                @if($orders->isEmpty())
                    <div class="mt-10 rounded-3xl border border-dashed border-slate-300 bg-slate-50 px-6 py-16 text-center">
                        <h2 class="text-lg font-bold text-slate-900">暂无订单</h2>
                        <p class="mt-2 text-sm text-slate-500">你还没有提交任何订单，立即选择商品开始定制吧。</p>
                        <a href="{{ route('products.index') }}" class="mt-6 inline-flex items-center justify-center rounded-2xl bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-600">开始定制</a>
                    </div>
                @else
                    <div class="mt-8 space-y-4">
                        @foreach($orders as $order)
                            <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                    <div>
                                        <div class="flex flex-wrap items-center gap-3">
                                            <h2 class="text-xl font-bold text-slate-950">{{ $order->order_no }}</h2>
                                            <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-slate-600">{{ $order->status_label }}</span>
                                        </div>
                                        <p class="mt-3 text-sm text-slate-600">项目：{{ optional($order->product)->name ?? '已删除商品' }}</p>
                                        <p class="mt-2 text-sm text-slate-500">创建时间：{{ $order->created_at->format('Y-m-d H:i') }}</p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center justify-center rounded-2xl bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-600">查看详情</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
