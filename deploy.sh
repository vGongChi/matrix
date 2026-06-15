#!/bin/bash

set -e  # 一步失败立即停止

echo "===== 🚀 开始部署 ====="

cd /var/www/matrix || exit

echo "拉取代码"
git fetch origin
git reset --hard origin/main

echo "安装 PHP 依赖"
composer install --no-dev --optimize-autoloader

echo "Laravel 优化"

php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "数据库迁移"
php artisan migrate --force

echo "权限修复"
chown -R www-data:www-data storage bootstrap/cache

echo "队列重启"
php artisan queue:restart

echo "===== ✅ 部署完成 ====="