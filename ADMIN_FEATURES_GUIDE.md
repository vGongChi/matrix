# Laravel Admin 管理功能使用指南

## 项目概述

本项目基于 Laravel Admin 框架，为您的网站后台实现了完整的内容管理功能。所有新增功能都已集成到后台管理系统中。

## 已创建的功能模块

### 1. 网站配置管理
- **路由**: `/admin/settings`
- **功能**: 管理网站基本信息（中英文名称、Logo、联系方式、微信二维码等）
- **表名**: `settings`

### 2. 首页内容管理

#### 2.1 Hero 区域
- **路由**: `/admin/hero-sections`
- **功能**: 管理首页顶部英雄区域（主标题、高亮文字、副标题、背景图）
- **表名**: `hero_sections`

#### 2.2 Hero 卖点
- **路由**: `/admin/hero-features`
- **功能**: 管理 Hero 区域下的卖点特性（图标、描述、排序）
- **表名**: `hero_features`

### 3. 服务管理
- **路由**: `/admin/services`
- **功能**: 管理公司提供的服务（名称、描述、图标、排序）
- **表名**: `services`

### 4. 案例管理

#### 4.1 案例列表
- **路由**: `/admin/cases`
- **功能**: 管理公司案例（标题、封面、描述、成果说明、关联标签）
- **表名**: `cases`

#### 4.2 案例标签
- **路由**: `/admin/case-tags`
- **功能**: 管理案例分类标签
- **表名**: `case_tags`

### 5. 优势管理
- **路由**: `/admin/advantages`
- **功能**: 管理公司优势（图标、标题、描述、排序）
- **表名**: `advantages`

### 6. 流程管理
- **路由**: `/admin/processes`
- **功能**: 管理合作流程步骤（步骤序号、标题、描述）
- **表名**: `processes`

### 7. CTA 区域
- **路由**: `/admin/cta-sections`
- **功能**: 管理行动召唤区域（标题、副标题）
- **表名**: `cta_sections`

### 8. 客户线索管理（核心功能）
- **路由**: `/admin/leads`
- **功能**: 管理客户线索（姓名、联系方式、需求、来源、状态）
- **表名**: `leads`
- **状态说明**:
  - 0: 未处理（黄色）
  - 1: 已联系（蓝色）
  - 2: 已成交（绿色）
  - 3: 无效（红色）

## 安装步骤

### 1. 运行数据库迁移

```bash
cd /Users/gongchi/home/www/admin-home

# 确保 MySQL 服务正在运行
# 然后执行迁移
php artisan migrate
```

**前提条件**:
- MySQL 服务必须运行
- `.env` 文件中的数据库配置正确（`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`）

### 2. 访问管理后台

在浏览器中访问:
```
http://yourapp.com/admin
```

登录后台管理系统后，左侧菜单中会显示所有新增的管理模块。

## 数据库迁移文件

已创建的迁移文件位于 `database/migrations/` 目录:

```
2025_06_04_000001_create_settings_table.php
2025_06_04_000002_create_hero_sections_table.php
2025_06_04_000003_create_hero_features_table.php
2025_06_04_000004_create_services_table.php
2025_06_04_000005_create_cases_table.php
2025_06_04_000006_create_case_tags_table.php
2025_06_04_000007_create_case_tag_relations_table.php
2025_06_04_000008_create_advantages_table.php
2025_06_04_000009_create_processes_table.php
2025_06_04_000010_create_cta_sections_table.php
2025_06_04_000011_create_leads_table.php
```

## Model 类

已创建的 Model 类位于 `app/Models/` 目录:

- `Settings.php` - 网站配置
- `HeroSection.php` - Hero 区域
- `HeroFeature.php` - Hero 卖点
- `Service.php` - 服务
- `Case_.php` - 案例（注：为避免与 PHP 关键字冲突，类名为 `Case_`，表名仍为 `cases`）
- `CaseTag.php` - 案例标签
- `Advantage.php` - 优势
- `Process.php` - 流程
- `CtaSection.php` - CTA 区域
- `Lead.php` - 客户线索

## Laravel Admin 控制器

已创建的控制器位于 `app/Admin/Controllers/` 目录:

- `SettingsController.php`
- `HeroSectionController.php`
- `HeroFeatureController.php`
- `ServiceController.php`
- `CaseController.php`
- `CaseTagController.php`
- `AdvantageController.php`
- `ProcessController.php`
- `CtaSectionController.php`
- `LeadController.php`

## 功能特性

### 图表功能
所有涉及图片的字段（Logo、Hero 背景、案例封面、微信二维码等）都支持:
- 图片上传
- 图片预览
- 图片存储到公共目录

### 排序功能
以下模块支持排序功能:
- Hero 卖点
- 服务
- 优势

### 关系管理
- 案例与标签之间建立多对多关系
- 支持在案例编辑页面直接选择关联标签

### 状态管理
客户线索管理包含状态跟踪:
- 使用颜色点表示不同的状态
- 支持批量更新状态

### 搜索和筛选
所有管理页面都支持:
- 按创建时间排序
- 按名称/标题搜索（可根据需要定制）
- 分页显示

## 常见操作

### 添加新的管理功能

如果需要添加新的数据表管理功能，按照以下步骤:

1. **创建迁移文件**:
```bash
php artisan make:migration create_your_table_name_table
```

2. **创建 Model**:
```bash
php artisan make:model YourModelName
```

3. **创建 Admin Controller**:
```bash
php artisan make:admin YourControllerName --model=YourModelName
```

4. **在 `app/Admin/routes.php` 中添加路由**:
```php
$router->resource('your-routes', 'YourControllerName');
```

### 自定义表单字段

在 Controller 的 `form()` 方法中可以自定义各种字段类型:

```php
// 文本输入
$form->text('field_name', __('标签'));

// 长文本
$form->textarea('field_name', __('标签'));

// 图片上传
$form->image('field_name', __('标签'))->disk('public');

// 下拉选择
$form->select('field_name', __('标签'))->options([...]);

// 多选
$form->multipleSelect('field_name', __('标签'))->options([...]);

// 数字
$form->number('field_name', __('标签'));

// 日期
$form->date('field_name', __('标签'));
```

### 自定义列表显示

在 Controller 的 `grid()` 方法中可以自定义列表展示:

```php
$grid->column('field_name', __('标签'));
$grid->column('image', __('图片'))->image('', 50, 50);
$grid->column('status', __('状态'))->dot([...]);
```

## 技术栈

- **框架**: Laravel 10.x
- **后台管理**: laravel-admin
- **数据库**: MySQL 5.7+
- **PHP**: 8.x

## 故障排除

### 问题 1: 迁移失败 - 数据库连接错误

**解决方案**:
1. 确保 MySQL 服务正在运行
2. 检查 `.env` 文件中的数据库配置
3. 确认数据库已创建

### 问题 2: 图片上传失败

**解决方案**:
1. 确保 `storage/app/public` 目录存在且可写
2. 运行: `php artisan storage:link`
3. 检查 Web 服务器是否有对 `public/storage` 的访问权限

### 问题 3: 后台菜单没有显示新模块

**解决方案**:
1. 清除配置缓存: `php artisan config:clear`
2. 清除路由缓存: `php artisan route:clear`
3. 清除视图缓存: `php artisan view:clear`

## 下一步建议

1. 为前端页面创建对应的视图模板，调用这些数据
2. 添加前端 API 路由来获取这些数据
3. 根据需要添加更多的验证规则和权限控制
4. 为客户线索添加邮件通知功能
5. 为案例、服务等数据添加SEO优化字段

## 文件修改清单

### 新增文件
- 11 个迁移文件
- 10 个 Model 类
- 10 个 Laravel Admin Controller
- 1 个 README 指南文件

### 修改文件
- `app/Admin/routes.php` - 添加了新的资源路由

## 支持

如有问题或需要进一步的定制，请参考:
- [Laravel 文档](https://laravel.com/docs)
- [Laravel Admin 文档](https://laravel-admin.org/docs)

---

**创建日期**: 2025-06-04  
**版本**: 1.0
