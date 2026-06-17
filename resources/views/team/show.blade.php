@extends('layouts.app')

@section('title', $team->name . ' | 团队展示 | ' . ($settings->site_name ?? '元亨微阵科技工作室'))

@section('content')
    @include('partials.header')

    <!-- 成员详情头部 -->
    <section class="w-full py-20 lg:py-32 px-8 lg:px-24">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- 成员图片展示 -->
            <div class="flex flex-col gap-6">
                <div class="relative rounded-2xl overflow-hidden border border-border">
                    @if($team->images && count($team->images) > 0)
                        <img src="{{ $team->images[0] }}" alt="{{ $team->name }}" class="w-full h-96 object-cover" id="mainImage" />
                    @else
                        <div class="w-full h-96 bg-muted flex items-center justify-center">
                            <iconify-icon icon="lucide:user" class="text-6xl text-muted-foreground"></iconify-icon>
                        </div>
                    @endif
                </div>

                <!-- 图片缩略图 -->
                @if($team->images && count($team->images) > 1)
                    <div class="flex gap-4 overflow-x-auto pb-2">
                        @foreach($team->images as $index => $image)
                            <img src="{{ $image }}" 
                                 alt="缩略图 {{ $index + 1 }}" 
                                 class="w-20 h-20 rounded-lg border-2 border-transparent hover:border-primary cursor-pointer transition-all flex-shrink-0 object-cover" 
                                 onclick="document.getElementById('mainImage').src = '{{ $image }}'" />
                        @endforeach
                    </div>
                @endif

                <!-- 音视频链接 -->
                <div class="flex gap-4">
                    @if($team->video_url)
                        <a href="{{ $team->video_url }}" target="_blank" class="flex-1 bg-primary text-primary-foreground px-6 py-4 rounded-xl font-bold hover:shadow-lg hover:shadow-primary/20 transition-all flex items-center justify-center gap-2">
                            <iconify-icon icon="lucide:play" class="text-xl"></iconify-icon>
                            观看视频介绍
                        </a>
                    @endif
                    @if($team->audio_url)
                        <a href="{{ $team->audio_url }}" target="_blank" class="flex-1 border border-border px-6 py-4 rounded-xl font-bold hover:bg-secondary transition-all flex items-center justify-center gap-2">
                            <iconify-icon icon="lucide:headphones" class="text-xl"></iconify-icon>
                            听音频介绍
                        </a>
                    @endif
                </div>
            </div>

            <!-- 成员信息 -->
            <div class="flex flex-col gap-8">
                <div>
                    <h1 class="text-5xl font-heading font-bold mb-2">{{ $team->name }}</h1>
                    @if($team->nickname)
                        <p class="text-xl text-primary font-semibold">{{ $team->nickname }}</p>
                    @endif
                </div>

                @if($team->position)
                    <div>
                        <h3 class="text-lg font-bold mb-2 flex items-center gap-2">
                            <iconify-icon icon="lucide:briefcase" class="text-primary"></iconify-icon>
                            岗位职责
                        </h3>
                        <p class="text-muted-foreground whitespace-pre-line">{{ $team->position }}</p>
                    </div>
                @endif

                @if($team->description)
                    <div>
                        <h3 class="text-lg font-bold mb-2 flex items-center gap-2">
                            <iconify-icon icon="lucide:file-text" class="text-primary"></iconify-icon>
                            个人介绍
                        </h3>
                        <p class="text-muted-foreground leading-relaxed whitespace-pre-line">{{ $team->description }}</p>
                    </div>
                @endif

                <!-- 联系或关注 -->
                <div class="pt-6 border-t border-border">
                    <a href="#contact" class="bg-primary text-primary-foreground px-8 py-4 rounded-xl font-bold hover:shadow-lg hover:shadow-primary/20 transition-all inline-flex items-center gap-2">
                        <iconify-icon icon="lucide:message-circle"></iconify-icon>
                        联系 {{ $team->name }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 其他团队成员推荐 -->
    @if($otherTeams->isNotEmpty())
        <section class="w-full py-24 px-8 lg:px-24 bg-muted/30">
            <h2 class="text-3xl font-heading font-bold mb-12">其他团队成员</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($otherTeams as $member)
                    <a href="{{ route('team.show', $member->id) }}" class="group">
                        <div class="bg-card rounded-2xl border border-border hover:border-primary/50 overflow-hidden transition-all hover:shadow-xl hover:shadow-primary/5">
                            <div class="relative h-48 bg-muted overflow-hidden">
                                @if($member->images && count($member->images) > 0)
                                    <img src="{{ $member->images[0] }}" alt="{{ $member->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <iconify-icon icon="lucide:user" class="text-4xl text-muted-foreground"></iconify-icon>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-bold">{{ $member->name }}</h3>
                                @if($member->position)
                                    <p class="text-sm text-muted-foreground mt-1">{{ $member->position }}</p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    @include('partials.footer')
@endsection
