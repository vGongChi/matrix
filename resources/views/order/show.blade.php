@extends('layouts.app')

@section('title', '订单详情 - ' . ($order->order_no ?? '订单'))
@section('meta_description', '查看订单 ' . ($order->order_no ?? '') . ' 的详情与当前进度。')

@section('content')
    @include('partials.header')

    <main class="min-h-screen bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-6xl space-y-8">
            <div class="rounded-3xl bg-white p-8 shadow-lg shadow-slate-200/50">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-primary">订单详情</p>
                        <h1 class="mt-3 text-3xl font-bold text-slate-950">订单号：{{ $order->order_no }}</h1>
                    </div>
                    <div class="inline-flex items-center gap-3 rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                        {{ $order->status_label }}
                    </div>
                </div>

                <div class="mt-8 grid gap-6 lg:grid-cols-3">
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                        <p class="text-sm text-slate-500">创建时间</p>
                        <p class="mt-3 text-lg font-semibold text-slate-950">{{ $order->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                        <p class="text-sm text-slate-500">项目</p>
                        <p class="mt-3 text-lg font-semibold text-slate-950">{{ optional($order->product)->name ?? '已删除商品' }}</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                        <p class="text-sm text-slate-500">剩余修改</p>
                        <p class="mt-3 text-lg font-semibold text-slate-950">{{ $order->remaining_revisions ?? 0 }} 次</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <section class="space-y-4 rounded-3xl bg-white p-8 shadow-lg shadow-slate-200/50 lg:col-span-2">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-slate-950">需求概览</h2>
                            <p class="mt-2 text-sm text-slate-500">订单已保存的结构化需求与补充说明。</p>
                        </div>
                        <a href="{{ route('orders.index') }}" class="text-sm font-semibold text-primary hover:text-blue-700">返回订单列表</a>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <h3 class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">结构化需求</h3>
                            @if(!empty($order->requirements) && is_array($order->requirements))
                                <div class="mt-4 space-y-3 rounded-3xl border border-slate-200 bg-slate-50 p-4">
                                    @foreach($order->requirements as $index => $requirement)
                                        <div class="rounded-2xl bg-white p-4 shadow-sm">
                                            <p class="text-sm font-semibold text-slate-900">需求 {{ $index + 1 }}</p>
                                            <p class="mt-2 text-sm leading-7 text-slate-600">
                                                @if(is_array($requirement))
                                                    @if(!empty($requirement['content']))
                                                        {{ $requirement['content'] }}
                                                    @else
                                                        {{ json_encode($requirement, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) }}
                                                    @endif
                                                @else
                                                    {{ $requirement }}
                                                @endif
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="mt-4 text-sm text-slate-500">暂无结构化需求内容。</p>
                            @endif
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">补充说明</h3>
                            <div class="mt-4 rounded-3xl border border-slate-200 bg-slate-50 p-5 text-sm leading-7 text-slate-700">
                                {{ $order->customer_notes ?: '客户未填写补充说明。' }}
                            </div>
                        </div>
                    </div>
                </section>

                <aside class="space-y-6 rounded-3xl bg-white p-8 shadow-lg shadow-slate-200/50">
                    <div class="space-y-3">
                        <h2 class="text-lg font-bold text-slate-950">价格摘要</h2>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <div class="flex items-center justify-between text-sm text-slate-500">
                                <span>项目总价</span>
                                <span>¥{{ number_format((float) $order->total_price, 2) }}</span>
                            </div>
                            <div class="mt-3 flex items-center justify-between text-sm text-slate-500">
                                <span>启动金</span>
                                <span>¥{{ number_format((float) $order->deposit_amount, 2) }}</span>
                            </div>
                            <div class="mt-3 flex items-center justify-between text-sm text-slate-500">
                                <span>尾款</span>
                                <span>¥{{ number_format((float) $order->final_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <h2 class="text-lg font-bold text-slate-950">当前状态</h2>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 text-sm leading-7 text-slate-700">
                            <p class="font-medium text-slate-900">{{ $order->status_label }}</p>
                            <p class="mt-3 text-slate-500">
                                @if($order->status === 'pending_deposit')
                                    订单已创建，待支付启动金后即可正式开始制作。
                                @elseif($order->status === 'processing')
                                    团队正在处理中，请耐心等待阶段性反馈。
                                @elseif($order->status === 'pending_final')
                                    初稿已完成，等待尾款支付后交付最终成果。
                                @elseif($order->status === 'completed')
                                    订单已完成，感谢您的信任。
                                @elseif($order->status === 'after_sale')
                                    订单进入售后阶段，正在处理您的后续需求。
                                @elseif($order->status === 'cancelled')
                                    订单已取消，如有疑问请联系项目顾问。
                                @else
                                    订单状态：{{ $order->status_label }}。
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <h2 class="text-lg font-bold text-slate-950">商品信息</h2>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 text-sm text-slate-700">
                            <p class="font-medium text-slate-900">{{ optional($order->product)->name ?? '已删除商品' }}</p>
                            <p class="mt-3">{{ optional($order->product)->level_text ? '级别：' . $order->product->level_text : '' }}</p>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>
@endsection
