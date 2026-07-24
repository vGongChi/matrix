@extends('layouts.app')

@section('title', 'AI极速工坊｜智作·快反')
@section('meta_description', '从原型、UI 到前后端开发，选择你现在需要的环节，AI 加速生成，人工精修交付。')

@section('content')
    @include('partials.header')

    <main class="overflow-hidden">
        <section class="relative px-6 py-20 lg:px-24 lg:py-28 bg-[#0b1220] text-white">
            <div class="absolute inset-0 opacity-30" style="background-image: linear-gradient(rgba(255,255,255,.08) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px); background-size: 48px 48px;"></div>
            <div class="absolute -right-20 -top-32 h-96 w-96 rounded-full bg-blue-500/30 blur-[100px]"></div>
            <div class="relative mx-auto max-w-7xl">
                <div class="max-w-3xl">
                    <div class="mb-6 flex items-center gap-3 text-sm font-semibold uppercase tracking-[0.28em] text-blue-300">
                        <span class="h-px w-10 bg-blue-300"></span>
                        AI FAST WORKSHOP
                    </div>
                    <h1 class="max-w-2xl text-4xl font-bold leading-tight tracking-tight sm:text-6xl">
                        智作·快反
                        <span class="block text-blue-300">把想法变成可交付的产品</span>
                    </h1>
                    <p class="mt-7 max-w-2xl text-base leading-8 text-slate-300 sm:text-lg">
                        你可以从任意一个环节切入。用大白话描述你的需求，我们进行提示词工程，AI 负责制作，技术人员判断与精修，按阶段购买，启动金开启制作，确认预览后再支付尾款。
                    </p>
                </div>

                <div class="mt-14 grid max-w-4xl grid-cols-2 gap-6 border-t border-white/15 pt-7 sm:grid-cols-4">
                    <div><strong class="block text-2xl">01</strong><span class="mt-1 block text-sm text-slate-400">提交结构化需求</span></div>
                    <div><strong class="block text-2xl">02</strong><span class="mt-1 block text-sm text-slate-400">AI 生成初稿</span></div>
                    <div><strong class="block text-2xl">03</strong><span class="mt-1 block text-sm text-slate-400">人工精修预览</span></div>
                    <div><strong class="block text-2xl">04</strong><span class="mt-1 block text-sm text-slate-400">确认后交付源文件</span></div>
                </div>
            </div>
        </section>

        <section class="bg-[#f6f8fb] px-6 py-16 lg:px-24 lg:py-24">
            <div class="mx-auto max-w-7xl">
                <div class="flex flex-col justify-between gap-6 border-b border-slate-200 pb-8 sm:flex-row sm:items-end">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-[0.22em] text-primary">Choose your entry point</p>
                        <h2 class="mt-3 text-3xl font-bold tracking-tight text-slate-950 sm:text-4xl">选择你现在需要的环节</h2>
                    </div>
                    <p class="max-w-md text-sm leading-7 text-slate-500">每个商品都包含人工精修与交付支持。商品下架后不会出现在前台，价格以提交订单时的快照为准。</p>
                </div>

                @if($products->isEmpty())
                    <div class="mt-12 border border-dashed border-slate-300 bg-white px-6 py-20 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-500">
                            <iconify-icon icon="lucide:package-open" class="text-2xl"></iconify-icon>
                        </div>
                        <h3 class="mt-5 text-lg font-bold text-slate-900">工坊正在准备中</h3>
                        <p class="mt-2 text-sm text-slate-500">暂时没有可购买的上架商品，请稍后再来查看。</p>
                    </div>
                @else
                    <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                        @foreach($products as $product)
                            @php
                                $image = $product->demo_images[0] ?? null;
                                $imageUrl = $image && (str_starts_with($image, 'http://') || str_starts_with($image, 'https://'))
                                    ? $image
                                    : ($image ? asset('storage/admin/' . ltrim($image, '/')) : null);
                                $levelClass = ['light' => 'bg-emerald-50 text-emerald-700', 'standard' => 'bg-blue-50 text-blue-700', 'heavy' => 'bg-amber-50 text-amber-700'][$product->level] ?? 'bg-slate-100 text-slate-700';
                            @endphp
                            <article class="group flex flex-col overflow-hidden border border-slate-200 bg-white transition duration-300 hover:-translate-y-1 hover:border-blue-300 hover:shadow-xl hover:shadow-blue-900/10">
                                <div class="relative aspect-[16/10] overflow-hidden bg-slate-100">
                                    @if($imageUrl)
                                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}参考图" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                                    @else
                                        <div class="flex h-full items-center justify-center bg-slate-900 text-slate-500">
                                            <iconify-icon icon="lucide:scan-line" class="text-5xl"></iconify-icon>
                                        </div>
                                    @endif
                                    <div class="absolute left-4 top-4 flex items-center gap-2">
                                        <span class="rounded-full px-3 py-1 text-xs font-bold {{ $levelClass }}">{{ $product->level_text }}</span>
                                        @if($product->requires_tech_stack)
                                            <span class="rounded-full bg-white/90 px-3 py-1 text-xs font-bold text-slate-700">需选技术栈</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex flex-1 flex-col p-6">
                                    <div class="flex items-start justify-between gap-4">
                                        <h3 class="text-xl font-bold leading-tight text-slate-950">{{ $product->name }}</h3>
                                        <span class="shrink-0 text-xs font-semibold text-slate-400">#{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    <p class="mt-3 min-h-12 text-sm leading-6 text-slate-500">从需求到可交付成果，包含 {{ $product->max_revisions }} 次免费修改。</p>

                                    @if($product->parent)
                                        <div class="mt-5 flex items-start gap-2 border-l-2 border-amber-400 bg-amber-50 px-3 py-2.5 text-xs leading-5 text-amber-800">
                                            <iconify-icon icon="lucide:triangle-alert" class="mt-0.5 shrink-0 text-base"></iconify-icon>
                                            <span>前置环节：{{ $product->parent->name }}。未购买时将加收 {{ rtrim(rtrim(number_format((float) $product->jump_fee_penalty, 2), '0'), '.') }}% 逆向工时费。</span>
                                        </div>
                                    @endif

                                    <div class="mt-6 grid grid-cols-2 gap-4 border-y border-slate-100 py-5">
                                        <div><span class="block text-xs text-slate-400">项目总价</span><strong class="mt-1 block text-2xl text-slate-950">¥{{ number_format((float) $product->price, 2) }}</strong></div>
                                        <div><span class="block text-xs text-slate-400">启动金 {{ rtrim(rtrim(number_format((float) $product->deposit_rate, 2), '0'), '.') }}%</span><strong class="mt-1 block text-2xl text-primary">¥{{ number_format((float) $product->getPricingSummary()['deposit_amount'], 2) }}</strong></div>
                                    </div>

                                    <div class="mt-auto flex items-center justify-between gap-4 pt-6">
                                        <span class="flex items-center gap-1.5 text-xs font-medium text-slate-500"><iconify-icon icon="lucide:refresh-cw" class="text-sm"></iconify-icon>{{ $product->max_revisions }} 次修改</span>
                                        <a href="#start-order" class="inline-flex items-center gap-2 bg-slate-950 px-4 py-3 text-sm font-bold text-white transition hover:bg-primary">开始定制 <iconify-icon icon="lucide:arrow-up-right"></iconify-icon></a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <section id="start-order" class="border-t border-slate-200 bg-white px-6 py-16 lg:px-24">
            <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-8 md:flex-row md:items-center">
                <div><p class="text-sm font-bold uppercase tracking-[0.22em] text-primary">Ready when you are</p><h2 class="mt-3 text-3xl font-bold text-slate-950">有明确需求了？从一个环节开始。</h2><p class="mt-3 text-slate-500">选择商品后填写结构化需求，我们会在确认启动金后开始制作。</p></div>
                <a href="mailto:{{ $settings->email ?? '' }}" class="inline-flex shrink-0 items-center gap-2 border border-slate-900 px-6 py-3 font-bold text-slate-900 transition hover:bg-slate-950 hover:text-white">联系项目顾问 <iconify-icon icon="lucide:arrow-right"></iconify-icon></a>
            </div>
        </section>
    </main>
@endsection
