<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');

    // 首页内容管理
    $router->resource('settings', 'SettingsController');//网站配置
    $router->resource('hero-sections', 'HeroSectionController');//Hero区域
    $router->resource('hero-features', 'HeroFeatureController');//Hero卖点
    
    // 服务和案例
    $router->resource('services', 'ServiceController');//服务管理
    $router->resource('cases', 'CaseController');//案例管理
    $router->resource('case-tags', 'CaseTagController');//案例标签
    
    // 优势和流程
    $router->resource('advantages', 'AdvantageController');//优势管理
    $router->resource('processes', 'ProcessController');//合作流程
    
    // CTA和客户线索
    $router->resource('cta-sections', 'CtaSectionController');//CTA行动区
    $router->resource('leads', 'LeadController');//客户线索

    // 团队管理
    $router->resource('teams', 'TeamController');//团队管理

    // 素材管理
    $router->resource('materials', 'MaterialController');//素材管理

});
 