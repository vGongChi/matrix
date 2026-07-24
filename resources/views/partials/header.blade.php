<header class="w-full h-20 flex items-center justify-between px-8 lg:px-24 border-b border-border bg-background/80 backdrop-blur-md sticky top-0 z-50">
    <div class="flex items-center gap-2">
      <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
        <img src="/storage/admin/images/logo.png" alt="Logo" style="height: 45px;width: 45px;" class="w-6 h-6 object-contain">
      </div>
      <div class="flex flex-col">
        <span class="font-heading font-bold text-lg leading-tight tracking-tight">{{ $settings->site_name ?? '元亨微阵科技工作室' }}</span>
        <span class="text-[10px] text-muted-foreground uppercase tracking-[0.2em]">{{ $settings->site_name_en ?? 'YUANHENG MATRIX STUDIO' }}</span>
      </div>
    </div>

    <nav class="hidden lg:flex items-center gap-10">
      <a href="{{ url('/') }}" class="text-sm font-medium hover:text-primary transition-colors">首页</a>
      <a href="{{ url('/#services') }}" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors">服务</a>
      <a href="{{ url('/#cases') }}" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors">案例</a>
      <a href="{{ url('/#process') }}" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors">流程</a>
      <a href="{{ url('/team') }}" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors">团队</a>
      <a href="{{ url('/material') }}" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors">开源中心</a>
      <a href="{{ url('/products') }}" class="text-sm font-semibold text-primary hover:text-primary/70 transition-colors">AI极速工坊</a>
    </nav>

    <a href="{{ url('/products') }}" class="bg-primary text-primary-foreground px-6 py-2.5 rounded-lg text-sm font-semibold hover:opacity-90 transition-opacity">控制台</a>
</header>

<div id="auth-modal" class="hidden fixed inset-0 z-50 bg-slate-950/50 flex items-center justify-center">
    <div class="bg-white rounded-2xl w-[460px] p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold">登录 / 注册</h3>
            <button type="button" data-close-auth-modal>关闭</button>
        </div>

        <div class="space-y-3">
            <input id="auth-email" type="email" placeholder="邮箱" class="w-full border rounded-lg px-3 py-2">
            <div class="flex gap-2">
                <input id="auth-code" type="text" placeholder="验证码" class="w-full border rounded-lg px-3 py-2">
                <button type="button" id="send-code-btn" class="bg-primary text-white px-4 rounded-lg">发送验证码</button>
            </div>
            <input id="auth-password" type="password" placeholder="密码" class="w-full border rounded-lg px-3 py-2">
            <input id="auth-name" type="text" placeholder="昵称（选填）" class="w-full border rounded-lg px-3 py-2">
            <button type="button" id="register-btn" class="w-full bg-slate-950 text-white py-3 rounded-lg">注册</button>
            <button type="button" id="login-btn" class="w-full border border-slate-300 py-3 rounded-lg">登录</button>
        </div>
    </div>
</div>

<style>
html {
  scroll-behavior: smooth;
}

section[id] {
  scroll-margin-top: 96px;
}
</style>

<script>
  document.addEventListener('click', function (event) {
    if (event.target.dataset.openAuthModal === '1') {
        document.getElementById('auth-modal').classList.remove('hidden');
    }

    if (event.target.dataset.closeAuthModal !== undefined) {
        document.getElementById('auth-modal').classList.add('hidden');
    }
});

document.getElementById('send-code-btn').addEventListener('click', async function () {
    const email = document.getElementById('auth-email').value;
    await fetch('/auth/send-code', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
        },
        body: JSON.stringify({ email })
    });
});

document.getElementById('register-btn').addEventListener('click', async function () {
    const payload = {
        email: document.getElementById('auth-email').value,
        code: document.getElementById('auth-code').value,
        password: document.getElementById('auth-password').value,
        name: document.getElementById('auth-name').value,
    };

    const res = await fetch('/auth/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
        },
        body: JSON.stringify(payload)
    });

    const data = await res.json();
    if (data.redirect) {
        window.location.href = data.redirect;
    }
});
</script>