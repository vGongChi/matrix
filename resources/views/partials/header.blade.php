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
      <a href="#" class="text-sm font-medium hover:text-primary transition-colors">首页</a>
      <a href="#services" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors">服务</a>
      <a href="#cases" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors">案例</a>
      <a href="#process" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors">流程</a>
      <a href="/team" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors">团队</a>
      <a href="/material" class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors">开源中心</a>
    </nav>
    
    <button class="bg-primary text-primary-foreground px-6 py-2.5 rounded-lg text-sm font-semibold hover:opacity-90 transition-opacity">
      立即咨询
    </button>
  </header>
