# 团队展示功能完整指南

## 功能概述

为你的网站创建了完整的团队展示系统，包括：
- 🎨 前端团队展示页面（列表和详情）
- 🛠️ 后台管理界面（CRUD 操作）
- 🔌 REST API 接口
- 📱 响应式设计，延续网站整体风格

## 数据库表结构

### teams 表字段说明

| 字段 | 类型 | 说明 |
|------|------|------|
| id | bigint | 主键 |
| name | string | 成员名字 |
| nickname | string | 昵称（可选） |
| position | text | 岗位职责（可选） |
| description | longtext | 文字介绍（可选） |
| images | json | 图片数组 JSON 格式 |
| video_url | string | 视频介绍地址（可选） |
| audio_url | string | 音频介绍地址（可选） |
| sort | integer | 排序（数字越小排序越靠前） |
| is_active | boolean | 是否启用 |
| created_at | timestamp | 创建时间 |
| updated_at | timestamp | 更新时间 |

## 文件清单

### 模型
- `app/Models/Team.php` - Team 模型，包含作用域方法

### 控制器
- `app/Http/Controllers/TeamController.php` - 前端控制器（Web）
- `app/Http/Controllers/Api/TeamController.php` - API 控制器（RESTful）
- `app/Admin/Controllers/TeamController.php` - 后台管理控制器

### 视图
- `resources/views/team/index.blade.php` - 团队列表页面
- `resources/views/team/show.blade.php` - 团队成员详情页面

### 数据库
- `database/migrations/2026_06_17_130500_create_teams_table.php` - 迁移文件

### 路由
- Web 路由已添加到 `routes/web.php`
- API 路由已添加到 `routes/api.php`
- 后台管理路由已添加到 `app/Admin/routes.php`

## 使用说明

### 1. 执行数据库迁移

```bash
php artisan migrate
```

### 2. 后台管理界面

访问 `/admin/teams` 可以进行以下操作：

#### 添加团队成员
1. 点击"新增"按钮
2. 填写表单信息：
   - **成员名字**（必填）
   - **昵称**（可选）：例如技能标签或代号
   - **岗位职责**（可选）：详细描述职位和责任
   - **文字介绍**（可选）：个人简介
   - **成员图片**（可选）：支持多张图片，第一张为主图
   - **视频介绍地址**（可选）：链接到视频
   - **音频介绍地址**（可选）：链接到音频
   - **排序**：数字越小排序越靠前
   - **启用**：开关状态

#### 编辑团队成员
1. 在列表中找到要编辑的成员
2. 点击"编辑"按钮
3. 修改相关信息后保存

#### 删除团队成员
1. 在列表中找到要删除的成员
2. 点击"删除"按钮确认

#### 启用/禁用成员
1. 在列表中切换"启用"开关
2. 只有启用的成员才会显示在前端

### 3. 前端页面

#### 团队列表页面
- **URL**: `/team`
- **功能**：
  - 展示所有启用的团队成员
  - 成员卡片包含：名字、昵称、岗位、简短介绍、主图
  - 悬停时显示视频和音频按钮
  - 点击卡片可进入成员详情页

#### 团队成员详情页面
- **URL**: `/team/{id}`
- **功能**：
  - 展示成员的完整信息
  - 图片轮播展示
  - 视频和音频播放入口
  - 岗位职责和文字介绍展示
  - 联系按钮
  - 推荐其他 3 个团队成员

### 4. API 接口

#### 获取所有团队成员
```
GET /api/teams
```
返回所有启用的团队成员列表（按排序字段排序）

#### 获取单个团队成员
```
GET /api/teams/{id}
```
返回指定成员的完整信息

#### 添加团队成员
```
POST /api/teams
Content-Type: application/json

{
  "name": "张三",
  "nickname": "小三",
  "position": "前端开发",
  "description": "专业前端开发工程师...",
  "images": ["https://example.com/image1.jpg", "https://example.com/image2.jpg"],
  "video_url": "https://example.com/video.mp4",
  "audio_url": "https://example.com/audio.mp3",
  "sort": 0,
  "is_active": true
}
```

#### 更新团队成员
```
PUT /api/teams/{id}
Content-Type: application/json

{
  "name": "张三",
  "nickname": "小三",
  "position": "高级前端开发",
  "description": "更新后的介绍...",
  "images": ["https://example.com/image1.jpg"],
  "sort": 1,
  "is_active": true
}
```

#### 删除团队成员
```
DELETE /api/teams/{id}
```

### 5. 图片字段说明

`images` 字段是 JSON 数组格式，存储多张图片 URL：

```json
[
  "https://example.com/member-main.jpg",
  "https://example.com/member-side1.jpg",
  "https://example.com/member-side2.jpg"
]
```

- **第一张图**：主图，显示在列表卡片和详情页面顶部
- **其他图**：详情页面可点击切换显示

### 6. 前端页面设计特色

- ✅ 延续网站整体 Tailwind 风格
- ✅ 响应式布局（手机/平板/桌面）
- ✅ 悬停效果和交互动画
- ✅ 图片轮播功能
- ✅ 视频和音频快捷入口
- ✅ 相关成员推荐
- ✅ 导航和页脚集成

## 数据示例

### 在后台管理中添加成员示例

```
名字: 李四
昵称: 设计总监
岗位职责: 主导产品视觉设计和 UI/UX 规划，带领设计团队完成高质量设计交付
文字介绍: 10 年设计经验，曾服务于多家知名 AI 企业，专注于产品设计和品牌视觉。
图片: [上传 3-5 张团队成员照片]
视频地址: https://example.com/videos/lisiwho.mp4
音频地址: https://example.com/audios/lisiwho.mp3
排序: 0
启用: 是
```

## 开发提示

### 自定义样式

如需修改样式，编辑以下文件中的 Tailwind CSS 类：
- `resources/views/team/index.blade.php` - 列表页样式
- `resources/views/team/show.blade.php` - 详情页样式

### 扩展功能

1. **添加社交媒体链接**：修改 Team 模型和迁移，添加 `twitter_url`, `github_url` 等字段

2. **添加技能标签**：创建 `TeamSkill` 关联表，显示成员的专业技能

3. **团队分组**：添加 `category` 字段，按部门或角色分类展示

4. **成员评价**：创建 `TeamReview` 模型，显示客户对成员工作的评价

## 常见问题

### Q: 如何排序团队成员？
A: 在后台管理界面修改 `sort` 字段，数字越小排序越靠前。前端会自动按此排序显示。

### Q: 如何禁用某个成员的显示？
A: 在后台管理界面切换 `启用` 开关关闭，或通过 API 设置 `is_active: false`。

### Q: 图片格式有要求吗？
A: 建议上传 JPG/PNG 格式，宽高比 1:1 或 16:9，最佳尺寸为 400x500 像素。

### Q: 如何实现批量导入团队成员？
A: 可以通过 API 或 CLI 命令批量导入。详见 API 文档。

## 后续优化建议

1. 添加图片裁剪和优化功能
2. 实现视频和音频的上传而不仅是链接
3. 添加团队成员的搜索和过滤功能
4. 集成生成个人二维码名片
5. 添加成员的年度回顾和成就展示
