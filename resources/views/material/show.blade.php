@extends('layouts.app')

@section('title', $material->title . ' | 素材分享 | ' . ($settings->site_name ?? '元亨微阵科技工作室'))

@section('content')
    @include('partials.header')

    @php
        $thumbnailUrls = $material->thumbnail ?? [];
        if (!is_array($thumbnailUrls)) {
            $thumbnailUrls = filled($thumbnailUrls) ? [$thumbnailUrls] : [];
        }
        $coverUrl = $thumbnailUrls[0] ?? null;
    @endphp

    <!-- 素材详情 -->
    <section class="w-full py-20 lg:py-32 px-8 lg:px-24">
        <div class="grid lg:grid-cols-3 gap-12">
            <!-- 素材内容展示 -->
            <div class="lg:col-span-2">
                <!-- 缩略图展示 -->
                @if(count($thumbnailUrls) > 0)
                    <div class="rounded-2xl overflow-hidden border border-border mb-8">
                        <div class="relative bg-black aspect-video overflow-hidden">
                            @if(count($thumbnailUrls) > 1)
                                @foreach($thumbnailUrls as $index => $url)
                                    <img
                                        src="/storage/admin/{{ $url }}"
                                        alt="{{ $material->title }}"
                                        class="carousel-image absolute inset-0 w-full h-full object-cover transition-opacity duration-500 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                                        data-carousel-index="{{ $index }}"
                                    />
                                @endforeach

                                <button type="button" onclick="prevImage()" class="absolute left-4 top-1/2 -translate-y-1/2 rounded-full bg-black/50 text-white p-3 hover:bg-black/70 transition">
                                    <iconify-icon icon="lucide:chevron-left"></iconify-icon>
                                </button>
                                <button type="button" onclick="nextImage()" class="absolute right-4 top-1/2 -translate-y-1/2 rounded-full bg-black/50 text-white p-3 hover:bg-black/70 transition">
                                    <iconify-icon icon="lucide:chevron-right"></iconify-icon>
                                </button>

                                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2">
                                    @foreach($thumbnailUrls as $index => $url)
                                        <button type="button" class="carousel-dot w-2.5 h-2.5 rounded-full transition-colors {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}" onclick="goToImage({{ $index }})"></button>
                                    @endforeach
                                </div>
                            @elseif(count($thumbnailUrls) === 1)
                                <img src="/storage/admin/{{ $thumbnailUrls[0] }}" alt="{{ $material->title }}" class="w-full h-full object-cover" />
                            @endif
                        </div>
                    </div>
                @endif

                <!-- 视频素材 -->
                @if($material->type === 'video')
                    <div class="rounded-2xl overflow-hidden border border-border mb-8 bg-black aspect-video flex items-center justify-center">
                        <video controls class="w-full h-full" poster="{{ $material->thumbnail }}">
                            <source src="{{ $material->video_url }}" type="video/mp4">
                            你的浏览器不支持视频播放
                        </video>
                    </div>
                @endif

                <!-- 文字素材 -->
                @if($material->type === 'text')
                    <div class="rounded-2xl overflow-hidden border border-border p-8 bg-card mb-8">
                        <div class="prose prose-sm max-w-none dark:prose-invert">
                            {!! nl2br(e($material->text_content)) !!}
                        </div>
                    </div>
                @endif

                <!-- 代码素材 -->
                @if($material->type === 'code')
                    <div class="rounded-2xl overflow-hidden border border-border mb-8">
                        <div class="bg-slate-900 text-slate-50 p-6">
                            <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-700">
                                <span class="text-sm font-semibold text-slate-400">{{ $material->code_language ?? '代码' }}</span>
                                <button class="px-3 py-1 rounded bg-slate-800 hover:bg-slate-700 text-sm font-semibold transition-colors" onclick="copyCode()">
                                    <iconify-icon icon="lucide:copy" class="mr-1"></iconify-icon>
                                    复制
                                </button>
                            </div>
                            <pre class="overflow-x-auto text-sm"><code id="codeContent">{{ $material->code_content }}</code></pre>
                        </div>
                    </div>

                    @if($material->code_repo_url)
                        <a href="{{ $material->code_repo_url }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-primary-foreground rounded-xl font-semibold hover:shadow-lg hover:shadow-primary/20 transition-all">
                            <iconify-icon icon="lucide:github"></iconify-icon>
                            查看完整代码
                        </a>
                    @endif
                @endif

                <!-- 素材信息 -->
                <div class="mt-12 pt-8 border-t border-border">
                    <h2 class="text-2xl font-bold mb-4">详细说明</h2>
                    @if($material->description)
                        <p class="text-muted-foreground leading-relaxed mb-6">{{ $material->description }}</p>
                    @else
                        <p class="text-muted-foreground">暂无详细说明</p>
                    @endif
                </div>
            </div>

            <!-- 侧边栏 -->
            <div class="lg:col-span-1">
                <!-- 素材卡片 -->
                <div class="rounded-2xl border border-border overflow-hidden bg-card sticky top-24">
                    <div class="aspect-video bg-muted overflow-hidden">
                        @if($coverUrl)
                            <img src="/storage/admin/{{ $coverUrl }}" alt="{{ $material->title }}" class="w-full h-full object-cover" />
                        @else
                            <div class="w-full h-full flex items-center justify-center text-muted-foreground text-sm">
                                暂无缩略图
                            </div>
                        @endif
                    </div>

                    <div class="p-6">
                        <h1 class="text-2xl font-bold mb-4">{{ $material->title }}</h1>

                        <!-- 类型标签 -->
                        <div class="flex items-center gap-2 mb-6">
                            @switch($material->type)
                                @case('image')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-blue-500/20 text-blue-600 text-xs font-semibold">
                                        <iconify-icon icon="lucide:image"></iconify-icon>
                                        图片素材
                                    </span>
                                    @break
                                @case('video')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-green-500/20 text-green-600 text-xs font-semibold">
                                        <iconify-icon icon="lucide:play"></iconify-icon>
                                        视频素材
                                    </span>
                                    @break
                                @case('text')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-purple-500/20 text-purple-600 text-xs font-semibold">
                                        <iconify-icon icon="lucide:file-text"></iconify-icon>
                                        文字素材
                                    </span>
                                    @break
                                @case('code')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-amber-500/20 text-amber-600 text-xs font-semibold">
                                        <iconify-icon icon="lucide:code"></iconify-icon>
                                        代码素材
                                    </span>
                                    @break
                            @endswitch
                        </div>

                        <!-- 分享按钮 -->
                        <div class="flex gap-3 mb-6">
                            <button onclick="shareToClipboard()" class="flex-1 bg-secondary hover:bg-muted text-foreground px-4 py-2.5 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                                <iconify-icon icon="lucide:share-2"></iconify-icon>
                                分享
                            </button>
                            @if(filled($material->image_url))
                                <a href="{{ $material->image_url }}" target="_blank" rel="noopener noreferrer" class="flex-1 bg-primary text-primary-foreground px-4 py-2.5 rounded-lg font-semibold hover:shadow-lg hover:shadow-primary/20 transition-all flex items-center justify-center gap-2">
                                    <iconify-icon icon="lucide:download"></iconify-icon>
                                    下载
                                </a>
                            @else
                                <button disabled class="flex-1 bg-muted text-muted-foreground px-4 py-2.5 rounded-lg font-semibold cursor-not-allowed flex items-center justify-center gap-2">
                                    <iconify-icon icon="lucide:download"></iconify-icon>
                                    下载
                                </button>
                            @endif
                        </div>

                        <button class="w-full bg-primary text-primary-foreground px-6 py-3 rounded-xl font-bold hover:shadow-lg hover:shadow-primary/20 transition-all flex items-center justify-center gap-2">
                            <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                            立即使用
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 相关素材推荐 -->
    @if($relatedMaterials->count() > 0)
        <section class="w-full py-24 px-8 lg:px-24 bg-muted/30">
            <h2 class="text-3xl font-heading font-bold mb-12">相关素材</h2>

            <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($relatedMaterials as $related)
                    @php
                        $relatedThumbnailUrls = $related->thumbnail ?? [];
                        if (!is_array($relatedThumbnailUrls)) {
                            $relatedThumbnailUrls = filled($relatedThumbnailUrls) ? [$relatedThumbnailUrls] : [];
                        }
                        $relatedCoverUrl = $relatedThumbnailUrls[0] ?? null;
                    @endphp
                    <a href="{{ route('material.show', $related->id) }}" class="group">
                        <div class="bg-card rounded-2xl border border-border hover:border-primary/50 overflow-hidden transition-all hover:shadow-xl hover:shadow-primary/5">
                            <div class="relative h-40 bg-muted overflow-hidden">
                                @if($relatedCoverUrl)
                                    <img src="/storage/admin/{{ $relatedCoverUrl }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-muted-foreground text-sm">
                                        暂无缩略图
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-sm line-clamp-2 group-hover:text-primary transition-colors">{{ $related->title }}</h3>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    @include('partials.footer')

    <script>
        function copyCode() {
            const code = document.getElementById('codeContent').innerText;
            navigator.clipboard.writeText(code).then(() => {
                alert('代码已复制到剪贴板');
            });
        }

        function shareToClipboard() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('分享链接已复制');
            });
        }

        let currentCarouselIndex = 0;
        const carouselImages = document.querySelectorAll('.carousel-image');
        const carouselDots = document.querySelectorAll('.carousel-dot');

        function updateCarousel(index) {
            if (!carouselImages.length) {
                return;
            }

            const total = carouselImages.length;
            currentCarouselIndex = (index + total) % total;

            carouselImages.forEach((img, idx) => {
                img.classList.toggle('opacity-100', idx === currentCarouselIndex);
                img.classList.toggle('opacity-0', idx !== currentCarouselIndex);
            });

            carouselDots.forEach((dot, idx) => {
                dot.classList.toggle('bg-white', idx === currentCarouselIndex);
                dot.classList.toggle('bg-white/50', idx !== currentCarouselIndex);
            });
        }

        function prevImage() {
            updateCarousel(currentCarouselIndex - 1);
        }

        function nextImage() {
            updateCarousel(currentCarouselIndex + 1);
        }

        function goToImage(index) {
            updateCarousel(index);
        }
    </script>
@endsection
