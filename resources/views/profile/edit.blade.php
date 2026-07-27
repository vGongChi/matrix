@extends('layouts.app')

@section('title', '个人资料')
@section('meta_description', '编辑你的个人资料与联系方式。')

@section('content')
    @include('partials.header')

    <main class="min-h-screen bg-slate-50 px-4 py-12 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <div class="rounded-3xl bg-white p-8 shadow-lg shadow-slate-200/50">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-primary">个人中心</p>
                        <h1 class="mt-3 text-3xl font-bold text-slate-950">个人资料</h1>
                        <p class="mt-2 text-sm text-slate-500">你可以编辑昵称、头像和手机号，邮箱仅作展示。</p>
                    </div>
                    <a href="{{ route('orders.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:border-primary hover:text-primary">返回订单列表</a>
                </div>

                @if(session('success'))
                    <div class="mt-8 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-6">
                    @csrf
                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">昵称</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">头像</label>
                            <input type="file" name="avatar" id="avatar-file-input" accept="image/*" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 file:mr-3 file:rounded-full file:border-0 file:bg-primary file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-600">
                            <p class="mt-2 text-xs text-slate-500">支持 JPG、PNG、WebP，最大 2MB。</p>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">手机号</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">邮箱</label>
                            <input type="email" value="{{ $user->email }}" disabled class="w-full rounded-2xl border border-slate-300 bg-slate-100 px-4 py-3 text-sm text-slate-500">
                        </div>
                    </div>

                    <div class="flex flex-col gap-6 border-t border-slate-200 pt-6 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-center gap-4">
                            @php
                                $avatarUrl = '';
                                if (!empty($user->avatar)) {
                                    if (strpos($user->avatar, 'http://') === 0 || strpos($user->avatar, 'https://') === 0) {
                                        $avatarUrl = $user->avatar;
                                    } else {
                                        $avatarUrl = asset('storage/' . $user->avatar);
                                    }
                                }
                            @endphp
                            @if($avatarUrl)
                                <img id="avatar-preview" src="{{ $avatarUrl }}" alt="头像预览" class="h-16 w-16 rounded-full object-cover ring-4 ring-slate-100">
                            @else
                                <div id="avatar-preview" class="flex h-16 w-16 items-center justify-center rounded-full bg-slate-900 text-xl font-bold text-white">{{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}</div>
                            @endif
                            <div>
                                <p class="text-sm font-semibold text-slate-900">当前头像</p>
                                <p class="text-sm text-slate-500">上传新图片即可立即替换。</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <p class="text-sm text-slate-500">邮箱仅支持查看，暂不允许修改。</p>
                            <button type="submit" class="inline-flex items-center justify-center rounded-2xl bg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-600">保存资料</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    const avatarFileInput = document.getElementById('avatar-file-input');
    const avatarPreview = document.getElementById('avatar-preview');

    if (avatarFileInput && avatarPreview) {
        avatarFileInput.addEventListener('change', function () {
            const file = this.files && this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (event) {
                avatarPreview.src = event.target.result;
                avatarPreview.className = 'h-16 w-16 rounded-full object-cover ring-4 ring-slate-100';
            };
            reader.readAsDataURL(file);
        });
    }
</script>
@endpush
