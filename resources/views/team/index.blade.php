@extends('layouts.app')

@section('title', '团队展示 | ' . ($settings->site_name ?? '元亨微阵科技工作室'))

@section('content')
    @include('partials.header')

    <!-- 团队展示头部 -->
    <section class="w-full py-20 lg:py-32 px-8 lg:px-24 text-center">
        <div class="max-w-3xl mx-auto">
            <span class="text-primary font-bold text-sm tracking-widest uppercase">我们的团队</span>
            <h1 class="text-4xl lg:text-6xl font-heading font-bold mt-6 leading-[1.2]">
                专业的团队，<span class="text-primary">创意的力量</span>
            </h1>
            <p class="text-lg text-muted-foreground mt-6">
                汇聚行业精英，致力于为 AI 产品与创新企业提供卓越的设计与开发服务
            </p>
        </div>
    </section>

    <!-- 团队成员卡片网格 -->
    <section class="w-full py-24 px-8 lg:px-24">
        @if($teams->isNotEmpty())
            <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($teams as $member)
                    <a href="{{ route('team.show', $member->id) }}" class="group">
                        <div class="bg-card rounded-2xl border border-border hover:border-primary/50 overflow-hidden transition-all hover:shadow-xl hover:shadow-primary/5">
                            <!-- 成员图片 -->
                            <div class="relative h-64 bg-muted overflow-hidden">
                                @if($member->images && count($member->images) > 0)
                                    <img src="/storage/admin/{{ $member->images[0] }}" alt="{{ $member->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <iconify-icon icon="lucide:user" class="text-4xl text-muted-foreground"></iconify-icon>
                                    </div>
                                @endif
                                
                                <!-- 悬停时显示音视频按钮 -->
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-4">
                                    @if($member->video_url)
                                        <a href="{{ $member->video_url }}" target="_blank" class="w-12 h-12 rounded-full bg-primary text-primary-foreground flex items-center justify-center hover:scale-110 transition-transform" title="视频介绍">
                                            <iconify-icon icon="lucide:play" class="text-xl"></iconify-icon>
                                        </a>
                                    @endif
                                    @if($member->audio_url)
                                        <a href="{{ $member->audio_url }}" target="_blank" class="w-12 h-12 rounded-full bg-primary text-primary-foreground flex items-center justify-center hover:scale-110 transition-transform" title="音频介绍">
                                            <iconify-icon icon="lucide:headphones" class="text-xl"></iconify-icon>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- 成员信息 -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold">{{ $member->name }}</h3>
                                @if($member->nickname)
                                    <p class="text-sm text-primary font-semibold mt-1">{{ $member->nickname }}</p>
                                @endif
                                @if($member->position)
                                    <p class="text-sm text-muted-foreground mt-2">{{ $member->position }}</p>
                                @endif
                                @if($member->description)
                                    <p class="text-sm text-muted-foreground mt-3 line-clamp-2">
                                        {{ $member->description }}
                                    </p>
                                @endif
                                
                                <!-- 查看详情链接 -->
                                <div class="mt-4 pt-4 border-t border-border flex items-center gap-1 text-primary font-semibold group-hover:gap-2 transition-all">
                                    查看详情 <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-20">
                <iconify-icon icon="lucide:users" class="text-6xl text-muted-foreground mx-auto mb-4"></iconify-icon>
                <p class="text-muted-foreground text-lg">暂无团队成员</p>
            </div>
        @endif
    </section>

    @include('partials.footer')
@endsection
