@extends('layouts.app')

@section('title', '素材分享 | ' . ($settings->site_name ?? '元亨微阵科技工作室'))

@section('content')
    @include('partials.header')

    <!-- 素材分享头部 -->
    <section class="w-full py-20 lg:py-32 px-8 lg:px-24 text-center">
        <div class="max-w-3xl mx-auto">
            <span class="text-primary font-bold text-sm tracking-widest uppercase">素材分享</span>
            <h1 class="text-4xl lg:text-6xl font-heading font-bold mt-6 leading-[1.2]">
                优质素材库，<span class="text-primary">助力创意落地</span>
            </h1>
            <p class="text-lg text-muted-foreground mt-6">
                精选设计素材、代码示例、文字模板和视频资源，为你的项目提速
            </p>
        </div>
    </section>

    <!-- 素材分类筛选 -->
    <section class="w-full py-12 px-8 lg:px-24 border-b border-border">
        <div class="flex flex-wrap gap-4 items-center justify-center">
            <a href="{{ route('material.index') }}" class="px-6 py-2.5 rounded-full font-semibold transition-all {{ !$type ? 'bg-primary text-primary-foreground' : 'bg-secondary text-foreground hover:bg-muted' }}">
                全部素材
            </a>
            @foreach($types as $typeKey => $typeName)
                <a href="{{ route('material.index', ['type' => $typeKey]) }}" class="px-6 py-2.5 rounded-full font-semibold transition-all {{ $type === $typeKey ? 'bg-primary text-primary-foreground' : 'bg-secondary text-foreground hover:bg-muted' }}">
                    {{ $typeName }}
                </a>
            @endforeach
        </div>
    </section>

    <!-- 素材卡片网格 -->
    <section class="w-full py-24 px-8 lg:px-24">
        @if($materials->count() > 0)
            <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
                @foreach($materials as $material)
                    <a href="{{ route('material.show', $material->id) }}" class="group">
                        <div class="bg-card rounded-2xl border border-border hover:border-primary/50 overflow-hidden transition-all hover:shadow-xl hover:shadow-primary/5">
                            <!-- 缩略图 -->
                            <div class="relative h-48 bg-muted overflow-hidden">
                                <img src="/storage/admin/{{ $material->thumbnail }}" alt="{{ $material->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                
                                <!-- 类型徽章 -->
                                <div class="absolute top-3 left-3">
                                    @switch($material->type)
                                        @case('image')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-500/20 text-blue-600 text-xs font-semibold">
                                                <iconify-icon icon="lucide:image" class="text-sm"></iconify-icon>
                                                图片
                                            </span>
                                            @break
                                        @case('video')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-500/20 text-green-600 text-xs font-semibold">
                                                <iconify-icon icon="lucide:play" class="text-sm"></iconify-icon>
                                                视频
                                            </span>
                                            @break
                                        @case('text')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-purple-500/20 text-purple-600 text-xs font-semibold">
                                                <iconify-icon icon="lucide:file-text" class="text-sm"></iconify-icon>
                                                文字
                                            </span>
                                            @break
                                        @case('code')
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-500/20 text-amber-600 text-xs font-semibold">
                                                <iconify-icon icon="lucide:code" class="text-sm"></iconify-icon>
                                                代码
                                            </span>
                                            @break
                                    @endswitch
                                </div>

                                <!-- 悬停覆盖层 -->
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-4">
                                    <iconify-icon icon="lucide:arrow-right" class="text-white text-3xl group-hover:translate-x-2 transition-transform"></iconify-icon>
                                </div>
                            </div>

                            <!-- 卡片信息 -->
                            <div class="p-4">
                                <h3 class="font-bold text-base mb-2 line-clamp-2 group-hover:text-primary transition-colors">{{ $material->title }}</h3>
                                @if($material->description)
                                    <p class="text-sm text-muted-foreground line-clamp-1">{{ $material->description }}</p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- 分页 -->
            @if($materials->hasPages())
                <div class="flex justify-center mt-12">
                    {{ $materials->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-20">
                <iconify-icon icon="lucide:inbox" class="text-6xl text-muted-foreground mx-auto mb-4"></iconify-icon>
                <p class="text-muted-foreground text-lg">暂无相关素材</p>
                @if($type)
                    <a href="{{ route('material.index') }}" class="text-primary font-semibold mt-4 inline-flex items-center gap-1 hover:gap-2 transition-all">
                        查看全部素材 <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                    </a>
                @endif
            </div>
        @endif
    </section>

    @include('partials.footer')
@endsection
