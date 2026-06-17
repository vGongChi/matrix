@extends('layouts.app')

@section('title', $settings->site_name ?? '元亨微阵科技工作室')

@section('content')
    @include('partials.header')

    <section class="w-full py-20 lg:py-32 px-8 lg:px-24 grid lg:grid-cols-2 gap-12 items-center overflow-hidden">
        <div class="flex flex-col gap-8">
            <div class="flex flex-col gap-4">
                <h1 class="text-4xl lg:text-6xl font-heading font-bold leading-[1.2]">
                    {!! optional($hero)->headline ?? '帮 <span class="text-primary">AI 产品</span><br/>快速上线官网与视觉系统' !!}
                </h1>
                <p class="text-lg text-muted-foreground">
                    {{ optional($hero)->subheadline ?? '设计 + 开发 + 动效一站式完成，最快 3 天交付' }}
                </p>
            </div>

            <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                @if($heroFeatures->isNotEmpty())
                    @foreach($heroFeatures as $feature)
                        <div class="flex items-center gap-2">
                            <iconify-icon icon="{{ $feature->icon }}" class="text-primary text-xl"></iconify-icon>
                            <span class="text-sm font-medium">{{ $feature->text ?? 'AI 加速交付' }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="flex items-center gap-2">
                        <iconify-icon icon="lucide:circle-check" class="text-primary text-xl"></iconify-icon>
                        <span class="text-sm font-medium">AI 加速交付</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <iconify-icon icon="lucide:circle-check" class="text-primary text-xl"></iconify-icon>
                        <span class="text-sm font-medium">高质量设计</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <iconify-icon icon="lucide:circle-check" class="text-primary text-xl"></iconify-icon>
                        <span class="text-sm font-medium">一站式服务</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <iconify-icon icon="lucide:circle-check" class="text-primary text-xl"></iconify-icon>
                        <span class="text-sm font-medium">长期技术支持</span>
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4 pt-4">
                <a href="{{ optional($hero)->primary_cta_url ?? '#contact' }}" class="bg-primary text-primary-foreground px-8 py-4 rounded-xl flex items-center gap-2 font-bold hover:shadow-lg hover:shadow-primary/20 transition-all">
                    {{ optional($hero)->primary_cta ?? '立即咨询' }}
                    <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                </a>
                <a href="{{ optional($hero)->secondary_cta_url ?? '#cases' }}" class="bg-background border border-border px-8 py-4 rounded-xl flex items-center gap-2 font-bold hover:bg-secondary transition-all">
                    {{ optional($hero)->secondary_cta ?? '查看案例' }}
                    <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                </a>
            </div>
        </div>

        <div class="relative">
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-primary/10 rounded-full blur-[100px] -z-10"></div>
            <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-blue-400/10 rounded-full blur-[80px] -z-10"></div>
            <img src="{{ $hero->image ? 'storage/admin/' . $hero->image : '' }}" class="w-full h-auto rounded-2xl shadow-2xl relative z-10" />
        </div>
    </section>

    <section id="services" class="w-full py-24 px-8 lg:px-24 bg-muted/30">
        <div class="text-center mb-16">
            <span class="text-primary font-bold text-sm tracking-widest uppercase">{{ $settings->services_title ?? '我们的服务' }}</span>
            <h2 class="text-3xl lg:text-4xl font-heading font-bold mt-4">{{ $settings->services_heading ?? '我们为您提供全流程数字化解决方案' }}</h2>
            <p class="text-muted-foreground mt-4">{{ $settings->services_subtitle ?? '从品牌视觉到产品落地，助力您的业务快速增长' }}</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @forelse($services as $service)
                <div class="bg-card p-10 rounded-2xl border border-border hover:border-primary/50 hover:shadow-xl hover:shadow-primary/5 transition-all group">
                    <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary transition-colors">
                        <iconify-icon icon="{{ $service->icon ?? 'lucide:monitor' }}" class="text-primary text-2xl group-hover:text-primary-foreground transition-colors"></iconify-icon>
                    </div>
                    <h3 class="text-xl font-bold mb-4">{{ $service->title ?? $service->name ?? '官网开发' }}</h3>
                    <p class="text-muted-foreground text-sm leading-relaxed mb-6">
                        {{ $service->description ?? '企业官网、产品官网、营销落地页，高性能、SEO 友好、响应式设计' }}
                    </p>
                    <a href="{{ $service->link ?? '#' }}" class="text-primary text-sm font-bold flex items-center gap-1 hover:gap-2 transition-all">
                        {{ $service->cta_text ?? '了解详情' }} <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                    </a>
                </div>
            @empty
                <div class="bg-card p-10 rounded-2xl border border-border hover:border-primary/50 hover:shadow-xl hover:shadow-primary/5 transition-all group">
                    <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary transition-colors">
                        <iconify-icon icon="lucide:monitor" class="text-primary text-2xl group-hover:text-primary-foreground transition-colors"></iconify-icon>
                    </div>
                    <h3 class="text-xl font-bold mb-4">官网开发</h3>
                    <p class="text-muted-foreground text-sm leading-relaxed mb-6">企业官网、产品官网、营销落地页，高性能、SEO 友好、响应式设计</p>
                    <a href="#" class="text-primary text-sm font-bold flex items-center gap-1 hover:gap-2 transition-all">了解详情 <iconify-icon icon="lucide:arrow-right"></iconify-icon></a>
                </div>
                <div class="bg-card p-10 rounded-2xl border border-border hover:border-primary/50 hover:shadow-xl hover:shadow-primary/5 transition-all group">
                    <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary transition-colors">
                        <iconify-icon icon="lucide:smartphone" class="text-primary text-2xl group-hover:text-primary-foreground transition-colors"></iconify-icon>
                    </div>
                    <h3 class="text-xl font-bold mb-4">UI/UX 设计</h3>
                    <p class="text-muted-foreground text-sm leading-relaxed mb-6">产品界面设计、用户体验优化，打造高转化、高体验的产品界面。</p>
                    <a href="#" class="text-primary text-sm font-bold flex items-center gap-1 hover:gap-2 transition-all">了解详情 <iconify-icon icon="lucide:arrow-right"></iconify-icon></a>
                </div>
                <div class="bg-card p-10 rounded-2xl border border-border hover:border-primary/50 hover:shadow-xl hover:shadow-primary/5 transition-all group">
                    <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-primary transition-colors">
                        <iconify-icon icon="lucide:play" class="text-primary text-2xl group-hover:text-primary-foreground transition-colors"></iconify-icon>
                    </div>
                    <h3 class="text-xl font-bold mb-4">动效设计</h3>
                    <p class="text-muted-foreground text-sm leading-relaxed mb-6">Lottie 动效、3D 动画、产品演示动画，让产品更生动。</p>
                    <a href="#" class="text-primary text-sm font-bold flex items-center gap-1 hover:gap-2 transition-all">了解详情 <iconify-icon icon="lucide:arrow-right"></iconify-icon></a>
                </div>
            @endforelse
        </div>
    </section>

    <section id="cases" class="w-full py-24 px-8 lg:px-24">
        <div class="flex items-end justify-between mb-16">
            <div>
                <span class="text-primary font-bold text-sm tracking-widest uppercase">{{ $settings->cases_title ?? '精选案例' }}</span>
                <h2 class="text-3xl lg:text-4xl font-heading font-bold mt-4">{{ $settings->cases_heading ?? '我们用专业与创意解决实际问题' }}</h2>
            </div>
            <a href="{{ $settings->cases_link ?? '#' }}" class="text-primary font-bold flex items-center gap-2 hover:underline">
                {{ $settings->cases_cta ?? '查看全部案例' }} <iconify-icon icon="lucide:arrow-right"></iconify-icon>
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @forelse($cases as $case)
                <div class="rounded-2xl overflow-hidden border border-border group">
                    <div class="h-64 bg-slate-900 flex items-center justify-center relative overflow-hidden">
                        <img src="{{ $case->cover ? 'storage/admin/' . $case->cover : '' }}" alt="{{ $case->title ?? '案例展示' }}" class="absolute inset-0 w-full h-full object-cover opacity-80" />
                        <div class="absolute inset-0 bg-gradient-to-br from-black/40 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 bg-white/10 backdrop-blur-md p-4 rounded-xl border border-white/20">
                            <h4 class="text-white font-bold">{{ $case->title ?? 'AI 驱动的智能写作平台' }}</h4>
                        </div>
                    </div>
                    <div class="p-6 bg-card">
                        <div class="flex flex-wrap gap-2 mb-4 text-[10px]">
                            @if($case->tags)
                                @foreach($case->tags as $tag)
                                    <span class="px-2 py-0.5 bg-secondary rounded-full font-medium">{{ $tag->name }}</span>
                                @endforeach
                            @endif
                        </div>
                        <p class="text-sm text-muted-foreground mb-4">{{ $case->description ?? '为 AI 写作工具打造的品牌官网，提升品牌专业度与信任感，转化率提升 40%。' }}</p>
                        <a href="{{ $case->link ?? '#' }}" class="text-primary text-sm font-bold flex items-center gap-1 group-hover:gap-2 transition-all">
                            {{ $case->cta_text ?? '查看详情' }} <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                        </a>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl overflow-hidden border border-border group">
                    <div class="h-64 bg-slate-900 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-transparent"></div>
                        <iconify-icon icon="lucide:zap" class="text-6xl text-primary/50"></iconify-icon>
                        <div class="absolute bottom-4 left-4 right-4 bg-white/10 backdrop-blur-md p-4 rounded-xl border border-white/20">
                            <h4 class="text-white font-bold">AI 驱动的智能写作平台</h4>
                        </div>
                    </div>
                    <div class="p-6 bg-card">
                        <div class="flex gap-2 mb-4">
                            <span class="text-[10px] px-2 py-0.5 bg-secondary rounded-full font-medium">官网开发</span>
                            <span class="text-[10px] px-2 py-0.5 bg-secondary rounded-full font-medium">UI/UX 设计</span>
                            <span class="text-[10px] px-2 py-0.5 bg-secondary rounded-full font-medium">动效设计</span>
                        </div>
                        <p class="text-sm text-muted-foreground mb-4">为 AI 写作工具打造的品牌官网，提升品牌专业度与信任感，转化率提升 40%。</p>
                        <a href="#" class="text-primary text-sm font-bold flex items-center gap-1 group-hover:gap-2 transition-all">查看详情 <iconify-icon icon="lucide:arrow-right"></iconify-icon></a>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <section class="w-full py-24 px-8 lg:px-24 bg-muted/30">
        <div class="text-center mb-16">
            <span class="text-primary font-bold text-sm tracking-widest uppercase">{{ $settings->advantages_title ?? '为什么选择我们' }}</span>
            <h2 class="text-3xl lg:text-4xl font-heading font-bold mt-4">{{ $settings->advantages_heading ?? 'AI 加速，让高质量交付更简单' }}</h2>
        </div>

        <div class="grid md:grid-cols-4 gap-8">
            @forelse($advantages as $advantage)
                <div class="flex flex-col items-center text-center p-6">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mb-6">
                        <iconify-icon icon="{{ $advantage->icon ?? 'lucide:zap' }}" class="text-primary text-3xl"></iconify-icon>
                    </div>
                    <h4 class="font-bold mb-2">{{ $advantage->title ?? 'AI 提效' }}</h4>
                    <p class="text-xs text-muted-foreground leading-relaxed">{{ $advantage->description ?? 'AI 工具辅助加速设计与开发，提升效率，缩短交付周期' }}</p>
                </div>
            @empty
                <div class="flex flex-col items-center text-center p-6">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mb-6">
                        <iconify-icon icon="lucide:zap" class="text-primary text-3xl"></iconify-icon>
                    </div>
                    <h4 class="font-bold mb-2">AI 提效</h4>
                    <p class="text-xs text-muted-foreground leading-relaxed">AI 工具辅助加速设计与开发，提升效率，缩短交付周期</p>
                </div>
                <div class="flex flex-col items-center text-center p-6">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mb-6">
                        <iconify-icon icon="lucide:target" class="text-primary text-3xl"></iconify-icon>
                    </div>
                    <h4 class="font-bold mb-2">专注 AI 产品</h4>
                    <p class="text-xs text-muted-foreground leading-relaxed">深入理解 AI 行业需求，打造更符合用户预期的产品</p>
                </div>
                <div class="flex flex-col items-center text-center p-6">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mb-6">
                        <iconify-icon icon="lucide:layers" class="text-primary text-3xl"></iconify-icon>
                    </div>
                    <h4 class="font-bold mb-2">一站式服务</h4>
                    <p class="text-xs text-muted-foreground leading-relaxed">设计、开发、动效全流程覆盖，一个团队，一次对接</p>
                </div>
                <div class="flex flex-col items-center text-center p-6">
                    <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mb-6">
                        <iconify-icon icon="lucide:message-circle" class="text-primary text-3xl"></iconify-icon>
                    </div>
                    <h4 class="font-bold mb-2">透明沟通</h4>
                    <p class="text-xs text-muted-foreground leading-relaxed">全程进度协作与进度同步，确保项目按质按量交付</p>
                </div>
            @endforelse
        </div>
    </section>

    <section id="process" class="w-full py-24 px-8 lg:px-24">
        <div class="text-center mb-20">
            <span class="text-primary font-bold text-sm tracking-widest uppercase">{{ $settings->processes_title ?? '合作流程' }}</span>
            <h2 class="text-3xl lg:text-4xl font-heading font-bold mt-4">{{ $settings->processes_heading ?? '简单 5 步，轻松合作' }}</h2>
        </div>

        <div class="relative max-w-5xl mx-auto">
            <div class="absolute top-8 left-0 right-0 h-0.5 bg-border -z-10 hidden md:block"></div>

            <div class="grid md:grid-cols-5 gap-8">
                @forelse($processes as $process)
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-primary/20 text-primary-foreground font-bold">{{ str_pad($process->step ?? $loop->iteration, 2, '0', STR_PAD_LEFT) }}</div>
                        <h4 class="font-bold mb-2">{{ $process->title ?? $process->name ?? '步骤 ' . ($process->step ?? $loop->iteration) }}</h4>
                        <p class="text-xs text-muted-foreground">{{ $process->description ?? '流程节点说明内容，帮助客户了解合作步骤。' }}</p>
                    </div>
                @empty
                    @foreach(range(1,5) as $step)
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-primary rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-primary/20 text-primary-foreground font-bold">{{ sprintf('%02d', $step) }}</div>
                            <h4 class="font-bold mb-2">0{{ $step }} 步骤标题</h4>
                            <p class="text-xs text-muted-foreground">流程节点说明内容，帮助客户了解合作步骤。</p>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <section class="w-full py-24 px-8 lg:px-24">
        <div class="bg-muted/30 rounded-[2rem] p-12 lg:p-20 text-center relative overflow-hidden">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/10 rounded-full blur-[80px]"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-primary/10 rounded-full blur-[80px]"></div>

            <h2 class="text-3xl lg:text-5xl font-heading font-bold mb-6">{{ $cta->title ?? '准备好让我们一起打造您的项目了吗？' }}</h2>
            <p class="text-muted-foreground text-lg mb-10 max-w-2xl mx-auto">{{ $cta->subtitle ?? '无论您是创业团队还是企业品牌，我们都能为您提供专业的解决方案' }}</p>

            <a href="{{ $cta->button_url ?? '#contact' }}" class="bg-primary text-primary-foreground px-10 py-5 rounded-2xl flex items-center gap-2 font-bold hover:shadow-xl hover:shadow-primary/20 transition-all mx-auto">
                {{ $cta->button_text ?? '立即咨询' }}
                <iconify-icon icon="lucide:arrow-right"></iconify-icon>
            </a>
        </div>
    </section>

    @include('partials.footer')
@endsection
