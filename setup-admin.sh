#!/bin/bash

# Laravel Admin 管理功能快速启动脚本

echo "======================================"
echo "Laravel Admin 管理功能启动脚本"
echo "======================================"
echo ""

# 检查 PHP 是否可用
if ! command -v php &> /dev/null; then
    echo "❌ 错误: PHP 未安装或不在 PATH 中"
    exit 1
fi

echo "✓ PHP 环境检查通过"
echo ""

# 检查 .env 文件
if [ ! -f .env ]; then
    echo "❌ 错误: .env 文件不存在"
    exit 1
fi

echo "✓ .env 文件存在"
echo ""

# 检查数据库配置
DB_HOST=$(grep DB_HOST .env | cut -d '=' -f2)
DB_DATABASE=$(grep DB_DATABASE .env | cut -d '=' -f2)

echo "数据库配置:"
echo "  Host: $DB_HOST"
echo "  Database: $DB_DATABASE"
echo ""

# 清除缓存
echo "清除应用缓存..."
php artisan config:clear > /dev/null 2>&1
php artisan route:clear > /dev/null 2>&1
php artisan view:clear > /dev/null 2>&1
echo "✓ 缓存已清除"
echo ""

# 运行迁移
echo "正在运行数据库迁移..."
echo "确保 MySQL 服务正在运行..."
echo ""

php artisan migrate

if [ $? -eq 0 ]; then
    echo ""
    echo "======================================"
    echo "✓ 迁移完成！"
    echo "======================================"
    echo ""
    echo "下一步:"
    echo "1. 访问后台管理: http://yourapp.com/admin"
    echo "2. 登录后在左侧菜单中查看所有新增管理模块"
    echo ""
    echo "新增的管理模块:"
    echo "  - 网站配置"
    echo "  - Hero 区域"
    echo "  - Hero 卖点"
    echo "  - 服务管理"
    echo "  - 案例管理"
    echo "  - 案例标签"
    echo "  - 优势管理"
    echo "  - 合作流程"
    echo "  - CTA 行动区"
    echo "  - 客户线索"
    echo ""
    echo "详细说明请参考: ADMIN_FEATURES_GUIDE.md"
else
    echo ""
    echo "======================================"
    echo "❌ 迁移失败"
    echo "======================================"
    echo ""
    echo "可能的原因:"
    echo "1. MySQL 服务未运行"
    echo "2. 数据库连接配置错误"
    echo "3. 数据库权限不足"
    echo ""
    echo "请检查以上配置后重试"
    exit 1
fi
