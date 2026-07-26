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

    @guest
        <a href="javascript:void(0)" data-open-auth-modal="1" class="bg-primary text-primary-foreground px-6 py-2.5 rounded-lg text-sm font-semibold hover:opacity-90 transition-opacity">登录</a>
    @else
        <a href="{{ route('orders.index') }}" class="bg-primary text-primary-foreground px-6 py-2.5 rounded-lg text-sm font-semibold hover:opacity-90 transition-opacity">控制台</a>
    @endguest
</header>

<div id="auth-modal" class="hidden fixed inset-0 z-50 bg-slate-950/50 flex items-center justify-center">
    <div class="bg-white rounded-2xl w-[460px] p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 id="auth-mode-title" class="text-xl font-bold">登录</h3>
            <button type="button" data-close-auth-modal>关闭</button>
        </div>

        <div class="space-y-3">
            <input id="auth-email" type="email" placeholder="邮箱" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
            <input id="auth-password" type="password" placeholder="密码" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">

            <div id="auth-code-group" class="flex gap-2 hidden">
                <input id="auth-code" type="text" placeholder="验证码" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
                <button type="button" id="send-code-btn" class="bg-primary text-white px-4 rounded-lg whitespace-nowrap">发送验证码</button>
            </div>

            <input id="auth-name" type="text" placeholder="昵称（选填）" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary hidden">

            <button type="button" id="login-btn" class="w-full bg-slate-950 text-white py-3 rounded-lg">登录</button>
            <button type="button" id="register-btn" class="w-full border border-slate-300 py-3 rounded-lg hidden">注册</button>

            <div class="text-sm text-slate-600">
                <span id="auth-switch-text">还没有账号，现在注册。</span>
            </div>
            <div id="auth-feedback" class="text-sm min-h-5"></div>
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
  const authModal = document.getElementById('auth-modal');
  const authFeedback = document.getElementById('auth-feedback');
  const authModeTitle = document.getElementById('auth-mode-title');
  const authSwitchText = document.getElementById('auth-switch-text');
  const authCodeGroup = document.getElementById('auth-code-group');
  const authNameInput = document.getElementById('auth-name');
  const loginBtn = document.getElementById('login-btn');
  const registerBtn = document.getElementById('register-btn');
  const emailInput = document.getElementById('auth-email');
  const passwordInput = document.getElementById('auth-password');
  const codeInput = document.getElementById('auth-code');

  let authMode = 'login';

  function showAuthFeedback(message, isError = false) {
    if (!authFeedback) return;
    authFeedback.textContent = message;
    authFeedback.className = `text-sm min-h-5 ${isError ? 'text-red-600' : 'text-slate-600'}`;
  }

  function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
  }

  function setInputError(input, hasError) {
    if (!input) return;
    input.classList.toggle('border-red-500', hasError);
    input.classList.toggle('focus:ring-red-500', hasError);
    input.classList.toggle('focus:ring-primary', !hasError);
  }

  function resetValidation() {
    [emailInput, passwordInput, codeInput].forEach((input) => setInputError(input, false));
  }

  function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  function setAuthMode(mode) {
    authMode = mode;
    const isRegister = mode === 'register';

    if (authModeTitle) {
      authModeTitle.textContent = isRegister ? '注册' : '登录';
    }

    if (authSwitchText) {
      authSwitchText.innerHTML = isRegister
        ? '<span class="cursor-pointer text-primary" data-switch-auth="login">已有帐号，现在去登录</span>'
        : '<span class="cursor-pointer text-primary" data-switch-auth="register">还没有账号，现在注册。</span>';
    }

    if (authCodeGroup) {
      authCodeGroup.classList.toggle('hidden', !isRegister);
    }
    if (authNameInput) {
      authNameInput.classList.toggle('hidden', !isRegister);
    }
    if (loginBtn) {
      loginBtn.classList.toggle('hidden', isRegister);
    }
    if (registerBtn) {
      registerBtn.classList.toggle('hidden', !isRegister);
    }
  }

  document.addEventListener('click', function (event) {
    const switchTarget = event.target.dataset.switchAuth;
    if (switchTarget) {
      setAuthMode(switchTarget);
      showAuthFeedback('');
      resetValidation();
      return;
    }

    if (event.target.dataset.openAuthModal === '1' && authModal) {
      authModal.classList.remove('hidden');
      setAuthMode('login');
      showAuthFeedback('');
      resetValidation();
    }

    if (event.target.dataset.closeAuthModal !== undefined && authModal) {
      authModal.classList.add('hidden');
    }
  });

  const sendCodeBtn = document.getElementById('send-code-btn');
  let sendCodeCooldown = 0;
  let sendCodeTimer = null;

  function startSendCodeCooldown() {
      if (!sendCodeBtn) return;

      sendCodeCooldown = 60;
      sendCodeBtn.disabled = true;
      sendCodeBtn.textContent = `重新发送(${sendCodeCooldown}s)`;

      if (sendCodeTimer) {
          clearInterval(sendCodeTimer);
      }

      sendCodeTimer = setInterval(function () {
          sendCodeCooldown -= 1;
          if (sendCodeCooldown <= 0) {
              clearInterval(sendCodeTimer);
              sendCodeBtn.disabled = false;
              sendCodeBtn.textContent = '发送验证码';
              return;
          }
          sendCodeBtn.textContent = `重新发送(${sendCodeCooldown}s)`;
      }, 1000);
  }

  if (sendCodeBtn) {
      sendCodeBtn.addEventListener('click', async function () {
          if (sendCodeCooldown > 0) {
              return;
          }

          resetValidation();
          const email = (emailInput?.value || '').trim();
          if (!email) {
              setInputError(emailInput, true);
              showAuthFeedback('请输入邮箱', true);
              return;
          }
          if (!validateEmail(email)) {
              setInputError(emailInput, true);
              showAuthFeedback('请输入有效的邮箱地址', true);
              return;
          }

          startSendCodeCooldown();

          const res = await fetch('/auth/send-code', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': getCsrfToken(),
                  'X-Requested-With': 'XMLHttpRequest'
              },
              body: JSON.stringify({ email })
          });

          const data = await res.json();
          showAuthFeedback(data.message || '验证码发送完成');

      });
  }

  if (registerBtn) {
      registerBtn.addEventListener('click', async function () {
          resetValidation();
          const email = (emailInput?.value || '').trim();
          const password = passwordInput?.value || '';
          const code = codeInput?.value || '';
          const name = authNameInput?.value || '';
          let hasError = false;

          if (!email) {
              setInputError(emailInput, true);
              hasError = true;
          } else if (!validateEmail(email)) {
              setInputError(emailInput, true);
              hasError = true;
          }

          if (!password) {
              setInputError(passwordInput, true);
              hasError = true;
          }

          if (!code) {
              setInputError(codeInput, true);
              hasError = true;
          }

          if (hasError) {
              showAuthFeedback('请填写完整信息', true);
              return;
          }

          const payload = { email, code, password, name };
          const res = await fetch('/auth/register', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': getCsrfToken(),
                  'X-Requested-With': 'XMLHttpRequest'
              },
              body: JSON.stringify(payload)
          });

          const data = await res.json();
          if (res.ok && data.redirect) {
              window.location.href = data.redirect;
              return;
          }

          showAuthFeedback(data.message || '注册失败', true);
      });
  }

  if (loginBtn) {
      loginBtn.addEventListener('click', async function () {
          resetValidation();
          const email = (emailInput?.value || '').trim();
          const password = passwordInput?.value || '';
          let hasError = false;

          if (!email) {
              setInputError(emailInput, true);
              hasError = true;
          } else if (!validateEmail(email)) {
              setInputError(emailInput, true);
              hasError = true;
          }

          if (!password) {
              setInputError(passwordInput, true);
              hasError = true;
          }

          if (hasError) {
              showAuthFeedback('请输入邮箱和密码', true);
              return;
          }

          const payload = { email, password };
          const res = await fetch('/auth/login', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': getCsrfToken(),
                  'X-Requested-With': 'XMLHttpRequest'
              },
              body: JSON.stringify(payload)
          });

          const data = await res.json();
          if (res.ok && data.redirect) {
              window.location.href = data.redirect;
              return;
          }

          showAuthFeedback(data.message || '登录失败', true);
      });
  }
</script>