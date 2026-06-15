# 📁 项目文件结构说明

## 新增文件位置和说明

```
/Users/gongchi/home/www/admin-home/
│
├── 📄 文档文件（新增）
│   ├── QUICK_REFERENCE.md                  ← 📍 快速参考卡片 (快速查看)
│   ├── SETUP_SUMMARY.md                    ← 📍 设置总结文档 (开始阅读)
│   ├── ADMIN_FEATURES_GUIDE.md             ← 详细功能指南
│   └── FRONTEND_INTEGRATION.md             ← 前端集成指南
│
├── 📜 启动脚本（新增）
│   └── setup-admin.sh                      ← 一键启动脚本 (执行权限已设置)
│
├── 📋 路由文件
│   ├── app/Admin/routes.php                ← ✏️ 已修改（添加了新的路由）
│   └── routes/api_example.php              ← 📍 新增 API 路由示例
│
├── 🗂️ 数据库迁移（11 个新增文件）
│   └── database/migrations/
│       ├── 2025_06_04_000001_create_settings_table.php
│       ├── 2025_06_04_000002_create_hero_sections_table.php
│       ├── 2025_06_04_000003_create_hero_features_table.php
│       ├── 2025_06_04_000004_create_services_table.php
│       ├── 2025_06_04_000005_create_cases_table.php
│       ├── 2025_06_04_000006_create_case_tags_table.php
│       ├── 2025_06_04_000007_create_case_tag_relations_table.php
│       ├── 2025_06_04_000008_create_advantages_table.php
│       ├── 2025_06_04_000009_create_processes_table.php
│       ├── 2025_06_04_000010_create_cta_sections_table.php
│       └── 2025_06_04_000011_create_leads_table.php
│
├── 🏛️ 模型类（10 个新增文件）
│   └── app/Models/
│       ├── Settings.php
│       ├── HeroSection.php
│       ├── HeroFeature.php
│       ├── Service.php
│       ├── Case_.php                       ← 注：避免与 PHP 关键字冲突
│       ├── CaseTag.php
│       ├── Advantage.php
│       ├── Process.php
│       ├── CtaSection.php
│       └── Lead.php
│
└── 🎛️ 后台控制器（10 个新增文件）
    └── app/Admin/Controllers/
        ├── SettingsController.php
        ├── HeroSectionController.php
        ├── HeroFeatureController.php
        ├── ServiceController.php
        ├── CaseController.php
        ├── CaseTagController.php
        ├── AdvantageController.php
        ├── ProcessController.php
        ├── CtaSectionController.php
        └── LeadController.php
```

## 📊 详细文件说明

### 📄 文档文件

#### 1. **QUICK_REFERENCE.md** ⭐ 最常用
- **用途**: 快速查看功能和常用命令
- **适合**: 所有使用者
- **内容**: 功能表、命令速查表、常用 API 列表

#### 2. **SETUP_SUMMARY.md** ⭐ 必读文档
- **用途**: 项目完整总结和快速开始指南
- **适合**: 所有人，特别是项目负责人
- **内容**: 完成清单、启动步骤、故障排除、文件清单

#### 3. **ADMIN_FEATURES_GUIDE.md**
- **用途**: 详细的功能说明和管理员指南
- **适合**: 后台管理员
- **内容**: 各个功能模块详解、安装步骤、常见操作、技术栈说明

#### 4. **FRONTEND_INTEGRATION.md**
- **用途**: 前端开发者集成指南
- **适合**: 前端工程师、全栈开发者
- **内容**: API 端点文档、Vue 3 示例、React 示例、常见问题

#### 5. **routes/api_example.php**
- **用途**: 完整的 API 路由代码示例
- **适合**: 后端开发者
- **内容**: 所有 API 端点的完整代码实现

### 📜 启动脚本

#### **setup-admin.sh**
```bash
# 功能：自动执行迁移前的检查和迁移
# 使用方法：
./setup-admin.sh

# 功能包括：
# 1. 检查 PHP 环境
# 2. 验证 .env 文件
# 3. 清除缓存
# 4. 执行数据库迁移
```

### 🗂️ 数据库迁移文件

每个迁移文件对应一个数据库表：

| 文件编号 | 功能 | 表名 |
|---------|------|------|
| 000001 | 网站基础配置 | `settings` |
| 000002 | Hero 区域 | `hero_sections` |
| 000003 | Hero 卖点 | `hero_features` |
| 000004 | 服务模块 | `services` |
| 000005 | 案例表 | `cases` |
| 000006 | 案例标签 | `case_tags` |
| 000007 | 案例标签关系表 | `case_tag_relations` |
| 000008 | 优势模块 | `advantages` |
| 000009 | 合作流程 | `processes` |
| 000010 | CTA 行动区 | `cta_sections` |
| 000011 | 客户线索 | `leads` |

### 🏛️ 模型类（Model）

位置: `app/Models/`

**Model 对应关系**:
```
Settings         ↔ settings 表
HeroSection      ↔ hero_sections 表
HeroFeature      ↔ hero_features 表
Service          ↔ services 表
Case_            ↔ cases 表 (注：Model 名称与表名不同)
CaseTag          ↔ case_tags 表
Advantage        ↔ advantages 表
Process          ↔ processes 表
CtaSection       ↔ cta_sections 表
Lead             ↔ leads 表
```

**关键关系**:
- `Case_` → `tags()` - 获取案例的所有标签
- `CaseTag` → `cases()` - 获取标签的所有案例

### 🎛️ 后台控制器（Controller）

位置: `app/Admin/Controllers/`

**Controller 功能**:
每个 Controller 都包含三个方法：
- `grid()` - 列表页面配置
- `form()` - 创建/编辑表单配置
- `detail()` - 详情页面配置

**控制器与管理路由对应**:
```
SettingsController       → /admin/settings
HeroSectionController    → /admin/hero-sections
HeroFeatureController    → /admin/hero-features
ServiceController        → /admin/services
CaseController          → /admin/cases
CaseTagController       → /admin/case-tags
AdvantageController     → /admin/advantages
ProcessController       → /admin/processes
CtaSectionController    → /admin/cta-sections
LeadController          → /admin/leads
```

### ✏️ 修改的文件

**app/Admin/routes.php** - 添加了新的资源路由

```php
// 已添加的路由组（在原有路由基础上）
$router->resource('settings', 'SettingsController');
$router->resource('hero-sections', 'HeroSectionController');
$router->resource('hero-features', 'HeroFeatureController');
$router->resource('services', 'ServiceController');
$router->resource('cases', 'CaseController');
$router->resource('case-tags', 'CaseTagController');
$router->resource('advantages', 'AdvantageController');
$router->resource('processes', 'ProcessController');
$router->resource('cta-sections', 'CtaSectionController');
$router->resource('leads', 'LeadController');
```

## 🔍 文件查找速查表

### 我想要...

| 需求 | 查看文件 | 快速导航 |
|------|--------|---------|
| 快速了解项目 | `QUICK_REFERENCE.md` | [🔗](#文档文件) |
| 完整的设置指南 | `SETUP_SUMMARY.md` | [🔗](#文档文件) |
| 后台管理说明 | `ADMIN_FEATURES_GUIDE.md` | [🔗](#文档文件) |
| 前端集成代码 | `FRONTEND_INTEGRATION.md` | [🔗](#文档文件) |
| API 端点代码 | `routes/api_example.php` | [🔗](#文档文件) |
| 修改数据库结构 | `database/migrations/` | [🔗](#-数据库迁移文件) |
| 修改数据逻辑 | `app/Models/` | [🔗](#-模型类model) |
| 修改后台页面 | `app/Admin/Controllers/` | [🔗](#-后台控制器controller) |
| 添加新的路由 | `app/Admin/routes.php` | [🔗](#-修改的文件) |
| 快速启动应用 | `setup-admin.sh` | [🔗](#-启动脚本) |

## 📦 文件统计

| 类别 | 数量 | 位置 |
|------|------|------|
| 迁移文件 | 11 | `database/migrations/` |
| Model 类 | 10 | `app/Models/` |
| Controller | 10 | `app/Admin/Controllers/` |
| 文档 | 4 | 项目根目录 |
| 脚本 | 1 | 项目根目录 |
| 总计 | **36** | — |

## 🎯 建议的查看顺序

1. **第一次使用** → 阅读 `QUICK_REFERENCE.md`
2. **需要详细说明** → 阅读 `SETUP_SUMMARY.md`
3. **前后端集成** → 阅读 `ADMIN_FEATURES_GUIDE.md`
4. **前端开发** → 阅读 `FRONTEND_INTEGRATION.md`
5. **查看代码** → 参考相应的 Model 或 Controller 文件

## 💡 快速导航链接

| 文档 | 链接 | 快速打开命令 |
|------|------|------------|
| 快速参考 | [QUICK_REFERENCE.md](./QUICK_REFERENCE.md) | `cat QUICK_REFERENCE.md` |
| 设置总结 | [SETUP_SUMMARY.md](./SETUP_SUMMARY.md) | `cat SETUP_SUMMARY.md` |
| 功能指南 | [ADMIN_FEATURES_GUIDE.md](./ADMIN_FEATURES_GUIDE.md) | `cat ADMIN_FEATURES_GUIDE.md` |
| 前端集成 | [FRONTEND_INTEGRATION.md](./FRONTEND_INTEGRATION.md) | `cat FRONTEND_INTEGRATION.md` |
| API 示例 | [routes/api_example.php](./routes/api_example.php) | `cat routes/api_example.php` |

---

**版本**: 1.0  
**最后更新**: 2026 年 6 月 4 日  
**状态**: ✅ 完整且可用
