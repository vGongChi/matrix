<footer class="w-full bg-foreground text-white py-20 px-8 lg:px-24">
    <div class="grid lg:grid-cols-4 gap-12 mb-16">
      <div class="flex flex-col gap-6">
        <div class="flex items-center gap-2">
          <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
            <iconify-icon icon="lucide:layers" class="text-primary-foreground text-2xl"></iconify-icon>
          </div>
          <div class="flex flex-col">
            <span class="font-heading font-bold text-lg leading-tight tracking-tight">{{ $settings->site_name ?? '元亨微阵科技工作室' }}</span>
            <span class="text-[10px] text-white/40 uppercase tracking-[0.2em]">{{ $settings->site_name_en ?? 'YUANHENG MATRIX STUDIO' }}</span>
          </div>
        </div>
        <p class="text-sm text-white/50 leading-relaxed">
          专注于为 AI 产品与创新企业提供<br/>网站开发、UI/UX 设计与动画制作服务，<br/>用技术与创意助力品牌成长。
        </p>
        <div class="flex gap-4">
          <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-colors">
            <iconify-icon icon="lucide:message-circle" class="text-lg"></iconify-icon>
          </a>
          <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-colors">
            <iconify-icon icon="lucide:mail" class="text-lg"></iconify-icon>
          </a>
          <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-colors">
            <iconify-icon icon="lucide:globe" class="text-lg"></iconify-icon>
          </a>
        </div>
      </div>
      
      <div>
        <h4 class="font-bold mb-8 text-lg">快速导航</h4>
        <ul class="flex flex-col gap-4 text-sm text-white/60">
          <li><a href="#" class="hover:text-primary transition-colors">首页</a></li>
          <li><a href="#services" class="hover:text-primary transition-colors">服务</a></li>
          <li><a href="#cases" class="hover:text-primary transition-colors">案例</a></li>
          <li><a href="#process" class="hover:text-primary transition-colors">流程</a></li>
          <li><a href="#team" class="hover:text-primary transition-colors">团队</a></li>
          <li><a href="#about" class="hover:text-primary transition-colors">关于我们</a></li>
        </ul>
      </div>
      
      <div>
        <h4 class="font-bold mb-8 text-lg">服务内容</h4>
        <ul class="flex flex-col gap-4 text-sm text-white/60">
          <li><a href="#" class="hover:text-primary transition-colors">官网开发</a></li>
          <li><a href="#" class="hover:text-primary transition-colors">UI/UX 设计</a></li>
          <li><a href="#" class="hover:text-primary transition-colors">动效设计</a></li>
          <li><a href="#" class="hover:text-primary transition-colors">小程序开发</a></li>
          <li><a href="#" class="hover:text-primary transition-colors">App 开发</a></li>
        </ul>
      </div>
      
      <div>
        <h4 class="font-bold mb-8 text-lg">联系我们</h4>
        <ul class="flex flex-col gap-4 text-sm text-white/60">
          <li class="flex items-center gap-2">
            <iconify-icon icon="lucide:phone" class="text-primary"></iconify-icon>
            {{ $settings->phone ?? '133 1234 5678' }}
          </li>
          <li class="flex items-center gap-2">
            <iconify-icon icon="lucide:mail" class="text-primary"></iconify-icon>
            {{ $settings->email ?? 'hello@yuanhengmatrix.com' }}
          </li>
          <li class="flex items-center gap-2">
            <iconify-icon icon="lucide:map-pin" class="text-primary"></iconify-icon>
            {{ $settings->address ?? '中国 · 杭州' }}
          </li>
        </ul>
        <div class="mt-8 p-4 bg-white/5 rounded-xl border border-white/10 inline-flex flex-col items-center gap-2">
          <div class="w-24 h-24 bg-white rounded-lg flex items-center justify-center">
            <iconify-icon icon="lucide:qr-code" class="text-black text-5xl"></iconify-icon>
          </div>
          <span class="text-[10px] text-white/40">微信咨询</span>
        </div>
      </div>
    </div>
    
    <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-white/30">
      <p>© {{ date('Y') }} {{ $settings->site_name ?? '元亨微阵科技工作室' }}. All Rights Reserved.</p>
      <div class="flex gap-8">
        <a href="#" class="hover:text-white transition-colors">隐私政策</a>
        <a href="#" class="hover:text-white transition-colors">服务条款</a>
      </div>
    </div>
  </footer>
