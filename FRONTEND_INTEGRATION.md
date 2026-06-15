# 前端集成指南

本文档说明如何在前端代码中使用后台管理系统创建的数据。

## 获取数据的 API 端点

### 1. 网站配置
```
GET /api/settings
```

**响应示例**:
```json
{
  "id": 1,
  "site_name": "我的公司",
  "site_name_en": "My Company",
  "logo": "/storage/logo.png",
  "phone": "13800138000",
  "email": "info@example.com",
  "address": "北京市朝阳区",
  "wechat_qr": "/storage/wechat.png"
}
```

### 2. Hero 区域
```
GET /api/hero-sections
```

**响应示例**:
```json
[
  {
    "id": 1,
    "title": "欢迎来到我们",
    "highlight_text": "创意设计",
    "subtitle": "我们提供优质的网站设计和开发服务",
    "image": "/storage/hero.jpg"
  }
]
```

### 3. Hero 卖点
```
GET /api/hero-features?sort=sort
```

**响应示例**:
```json
[
  {
    "id": 1,
    "icon": "mdi:rocket",
    "text": "快速部署",
    "sort": 1
  },
  {
    "id": 2,
    "icon": "mdi:shield",
    "text": "安全可靠",
    "sort": 2
  }
]
```

### 4. 服务列表
```
GET /api/services?sort=sort
```

**响应示例**:
```json
[
  {
    "id": 1,
    "title": "网站设计",
    "description": "专业的网站设计服务",
    "icon": "mdi:palette",
    "sort": 1
  }
]
```

### 5. 案例列表
```
GET /api/cases
GET /api/cases/{id}
```

**响应示例**:
```json
[
  {
    "id": 1,
    "title": "案例标题",
    "cover": "/storage/case-1.jpg",
    "description": "案例详细描述",
    "result": "成功增加了 50% 的转化率",
    "tags": [
      {"id": 1, "name": "电商"},
      {"id": 2, "name": "营销"}
    ]
  }
]
```

### 6. 案例标签
```
GET /api/case-tags
```

### 7. 优势列表
```
GET /api/advantages?sort=sort
```

**响应示例**:
```json
[
  {
    "id": 1,
    "icon": "mdi:star",
    "title": "专业团队",
    "description": "有 10+ 年的行业经验",
    "sort": 1
  }
]
```

### 8. 合作流程
```
GET /api/processes
```

**响应示例**:
```json
[
  {
    "id": 1,
    "step": 1,
    "title": "需求沟通",
    "description": "深入了解您的需求"
  },
  {
    "id": 2,
    "step": 2,
    "title": "方案设计",
    "description": "制定详细的实施方案"
  }
]
```

### 9. CTA 区域
```
GET /api/cta-sections
```

### 10. 提交客户线索
```
POST /api/leads
```

**请求体**:
```json
{
  "name": "客户名称",
  "contact": "13800138000 或 email@example.com",
  "message": "客户需求描述",
  "source": "网站"
}
```

**响应示例**:
```json
{
  "id": 1,
  "name": "客户名称",
  "contact": "13800138000",
  "message": "客户需求描述",
  "source": "网站",
  "status": 0,
  "created_at": "2025-06-04T12:00:00.000000Z"
}
```

## 前端集成示例

### Vue 3 + Axios 示例

```vue
<template>
  <div>
    <!-- Hero 区域 -->
    <section class="hero">
      <div v-if="hero" class="hero-content">
        <h1>{{ hero.title }}</h1>
        <span class="highlight">{{ hero.highlight_text }}</span>
        <p>{{ hero.subtitle }}</p>
        <img :src="hero.image" :alt="hero.title">
      </div>
    </section>

    <!-- Hero 卖点 -->
    <section class="features">
      <div v-for="feature in features" :key="feature.id" class="feature-item">
        <i :class="feature.icon"></i>
        <p>{{ feature.text }}</p>
      </div>
    </section>

    <!-- 服务列表 -->
    <section class="services">
      <div v-for="service in services" :key="service.id" class="service-card">
        <h3>{{ service.title }}</h3>
        <p>{{ service.description }}</p>
      </div>
    </section>

    <!-- 案例列表 -->
    <section class="cases">
      <div v-for="case_ in cases" :key="case_.id" class="case-item">
        <img :src="case_.cover" :alt="case_.title">
        <h3>{{ case_.title }}</h3>
        <p>{{ case_.description }}</p>
        <span v-for="tag in case_.tags" :key="tag.id" class="tag">
          {{ tag.name }}
        </span>
      </div>
    </section>

    <!-- 优势模块 -->
    <section class="advantages">
      <div v-for="advantage in advantages" :key="advantage.id" class="advantage-item">
        <i :class="advantage.icon"></i>
        <h3>{{ advantage.title }}</h3>
        <p>{{ advantage.description }}</p>
      </div>
    </section>

    <!-- 合作流程 -->
    <section class="processes">
      <div v-for="process in processes" :key="process.id" class="process-step">
        <span class="step">{{ process.step }}</span>
        <h3>{{ process.title }}</h3>
        <p>{{ process.description }}</p>
      </div>
    </section>

    <!-- 客户线索表单 -->
    <section class="contact-form">
      <form @submit.prevent="submitLead">
        <input v-model="leadForm.name" type="text" placeholder="您的名称" required>
        <input v-model="leadForm.contact" type="text" placeholder="联系方式" required>
        <textarea v-model="leadForm.message" placeholder="需求描述"></textarea>
        <button type="submit">提交</button>
      </form>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const hero = ref(null)
const features = ref([])
const services = ref([])
const cases = ref([])
const advantages = ref([])
const processes = ref([])

const leadForm = ref({
  name: '',
  contact: '',
  message: '',
})

const apiClient = axios.create({
  baseURL: '/api',
  headers: {
    'Content-Type': 'application/json'
  }
})

onMounted(async () => {
  try {
    // 获取 Hero 区域
    const heroResponse = await apiClient.get('/hero-sections')
    hero.value = heroResponse.data[0]

    // 获取 Hero 卖点
    const featuresResponse = await apiClient.get('/hero-features')
    features.value = featuresResponse.data

    // 获取服务列表
    const servicesResponse = await apiClient.get('/services')
    services.value = servicesResponse.data

    // 获取案例
    const casesResponse = await apiClient.get('/cases')
    cases.value = casesResponse.data

    // 获取优势
    const advantagesResponse = await apiClient.get('/advantages')
    advantages.value = advantagesResponse.data

    // 获取流程
    const processesResponse = await apiClient.get('/processes')
    processes.value = processesResponse.data
  } catch (error) {
    console.error('获取数据失败:', error)
  }
})

const submitLead = async () => {
  try {
    const response = await apiClient.post('/leads', {
      ...leadForm.value,
      source: '网站'
    })
    console.log('线索提交成功:', response.data)
    // 重置表单
    leadForm.value = { name: '', contact: '', message: '' }
    alert('感谢您的反馈！我们会尽快与您联系。')
  } catch (error) {
    console.error('提交失败:', error)
    alert('提交失败，请稍后重试')
  }
}
</script>
```

### React 示例

```jsx
import { useState, useEffect } from 'react'
import axios from 'axios'

export default function HomePage() {
  const [hero, setHero] = useState(null)
  const [features, setFeatures] = useState([])
  const [services, setServices] = useState([])
  const [cases, setCases] = useState([])
  const [advantages, setAdvantages] = useState([])
  const [processes, setProcesses] = useState([])
  const [leadForm, setLeadForm] = useState({
    name: '',
    contact: '',
    message: ''
  })

  useEffect(() => {
    fetchData()
  }, [])

  const fetchData = async () => {
    try {
      const [heroRes, featuresRes, servicesRes, casesRes, advantagesRes, processesRes] = 
        await Promise.all([
          axios.get('/api/hero-sections'),
          axios.get('/api/hero-features'),
          axios.get('/api/services'),
          axios.get('/api/cases'),
          axios.get('/api/advantages'),
          axios.get('/api/processes')
        ])

      setHero(heroRes.data[0])
      setFeatures(featuresRes.data)
      setServices(servicesRes.data)
      setCases(casesRes.data)
      setAdvantages(advantagesRes.data)
      setProcesses(processesRes.data)
    } catch (error) {
      console.error('获取数据失败:', error)
    }
  }

  const handleSubmitLead = async (e) => {
    e.preventDefault()
    try {
      await axios.post('/api/leads', {
        ...leadForm,
        source: '网站'
      })
      alert('感谢您的反馈！我们会尽快与您联系。')
      setLeadForm({ name: '', contact: '', message: '' })
    } catch (error) {
      alert('提交失败，请稍后重试')
    }
  }

  return (
    <div>
      {/* Hero 区域 */}
      {hero && (
        <section className="hero">
          <h1>{hero.title}</h1>
          <span className="highlight">{hero.highlight_text}</span>
          <p>{hero.subtitle}</p>
          <img src={hero.image} alt={hero.title} />
        </section>
      )}

      {/* 其他部分... */}
      
      {/* 表单 */}
      <form onSubmit={handleSubmitLead}>
        <input
          type="text"
          value={leadForm.name}
          onChange={(e) => setLeadForm({...leadForm, name: e.target.value})}
          placeholder="您的名称"
          required
        />
        <input
          type="text"
          value={leadForm.contact}
          onChange={(e) => setLeadForm({...leadForm, contact: e.target.value})}
          placeholder="联系方式"
          required
        />
        <textarea
          value={leadForm.message}
          onChange={(e) => setLeadForm({...leadForm, message: e.target.value})}
          placeholder="需求描述"
        />
        <button type="submit">提交</button>
      </form>
    </div>
  )
}
```

## 创建 API 路由

如果还没有创建 API 路由，需要在 `routes/api.php` 中添加:

```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\{Settings, HeroSection, HeroFeature, Service, Case_, CaseTag, Advantage, Process, CtaSection, Lead};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('api')->group(function () {
    
    // 获取网站配置
    Route::get('/settings', function () {
        return Settings::first();
    });

    // Hero 内容
    Route::get('/hero-sections', function () {
        return HeroSection::all();
    });

    Route::get('/hero-features', function () {
        return HeroFeature::orderBy('sort')->get();
    });

    // 服务列表
    Route::get('/services', function () {
        return Service::orderBy('sort')->get();
    });

    // 案例管理
    Route::get('/cases', function () {
        return Case_::with('tags')->get();
    });

    Route::get('/cases/{id}', function ($id) {
        return Case_::with('tags')->findOrFail($id);
    });

    Route::get('/case-tags', function () {
        return CaseTag::all();
    });

    // 优势列表
    Route::get('/advantages', function () {
        return Advantage::orderBy('sort')->get();
    });

    // 流程
    Route::get('/processes', function () {
        return Process::orderBy('step')->get();
    });

    // CTA
    Route::get('/cta-sections', function () {
        return CtaSection::all();
    });

    // 客户线索
    Route::post('/leads', function (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'contact' => 'required|string|max:255',
            'message' => 'nullable|string',
            'source' => 'nullable|string|max:100',
        ]);

        return Lead::create($validated);
    });

    Route::get('/leads', function () {
        return Lead::latest()->get();
    });
});
```

## 常见问题

### Q: 如何按标签筛选案例?
```javascript
// 前端代码
const filterCasesByTag = (tagId) => {
  return cases.filter(c => 
    c.tags.some(t => t.id === tagId)
  )
}
```

### Q: 如何实现分页?
```javascript
// 更新 API 路由以支持分页
Route::get('/cases', function () {
    return Case_::with('tags')->paginate(12);
});

// 前端代码
const [page, setPage] = useState(1)
const response = await axios.get(`/api/cases?page=${page}`)
```

### Q: 如何实现搜索?
```php
// 在 routes/api.php 中
Route::get('/cases/search', function (Request $request) {
    $query = $request->query('q');
    return Case_::where('title', 'like', "%{$query}%")
        ->orWhere('description', 'like', "%{$query}%")
        ->with('tags')
        ->get();
});
```

## 性能优化建议

1. **缓存数据**: 对不经常变化的数据（如服务、优势）使用缓存
2. **图片优化**: 对上传的图片进行压缩和优化
3. **API 限流**: 添加请求限流以防止滥用
4. **分页加载**: 对案例等大数据列表使用分页或无限滚动

---

**更新日期**: 2025-06-04
