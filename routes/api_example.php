<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\{Settings, HeroSection, HeroFeature, Service, Case_, CaseTag, Advantage, Process, CtaSection, Lead};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('api')->group(function () {
    
    // ==========================================
    // 网站基础配置
    // ==========================================
    
    /**
     * 获取网站配置信息
     * GET /api/settings
     */
    Route::get('/settings', function () {
        return Settings::first() ?? [];
    });

    // ==========================================
    // Hero 区域内容
    // ==========================================
    
    /**
     * 获取 Hero 区域
     * GET /api/hero-sections
     */
    Route::get('/hero-sections', function () {
        return HeroSection::all();
    });

    /**
     * 获取 Hero 卖点，支持排序
     * GET /api/hero-features
     */
    Route::get('/hero-features', function () {
        return HeroFeature::orderBy('sort')->get();
    });

    // ==========================================
    // 服务管理
    // ==========================================
    
    /**
     * 获取所有服务，按排序顺序
     * GET /api/services
     */
    Route::get('/services', function () {
        return Service::orderBy('sort')->get();
    });

    /**
     * 获取单个服务详情
     * GET /api/services/{id}
     */
    Route::get('/services/{id}', function ($id) {
        return Service::findOrFail($id);
    });

    // ==========================================
    // 案例管理
    // ==========================================
    
    /**
     * 获取所有案例，包含关联的标签
     * GET /api/cases
     * 支持参数: ?page=1&per_page=12
     */
    Route::get('/cases', function (Request $request) {
        $query = Case_::with('tags');
        
        if ($request->has('tag_id')) {
            $query->whereHas('tags', function ($q) {
                $q->where('id', request('tag_id'));
            });
        }
        
        return $query->paginate($request->get('per_page', 12));
    });

    /**
     * 获取单个案例详情
     * GET /api/cases/{id}
     */
    Route::get('/cases/{id}', function ($id) {
        return Case_::with('tags')->findOrFail($id);
    });

    /**
     * 获取所有案例标签
     * GET /api/case-tags
     */
    Route::get('/case-tags', function () {
        return CaseTag::withCount('cases')->get();
    });

    /**
     * 获取单个标签的案例
     * GET /api/case-tags/{id}/cases
     */
    Route::get('/case-tags/{id}/cases', function ($id) {
        return CaseTag::findOrFail($id)->cases()->with('tags')->get();
    });

    // ==========================================
    // 优势管理
    // ==========================================
    
    /**
     * 获取所有优势，按排序顺序
     * GET /api/advantages
     */
    Route::get('/advantages', function () {
        return Advantage::orderBy('sort')->get();
    });

    /**
     * 获取单个优势详情
     * GET /api/advantages/{id}
     */
    Route::get('/advantages/{id}', function ($id) {
        return Advantage::findOrFail($id);
    });

    // ==========================================
    // 合作流程
    // ==========================================
    
    /**
     * 获取所有合作流程步骤
     * GET /api/processes
     */
    Route::get('/processes', function () {
        return Process::orderBy('step')->get();
    });

    /**
     * 获取单个流程步骤
     * GET /api/processes/{id}
     */
    Route::get('/processes/{id}', function ($id) {
        return Process::findOrFail($id);
    });

    // ==========================================
    // CTA 行动区
    // ==========================================
    
    /**
     * 获取 CTA 区域信息
     * GET /api/cta-sections
     */
    Route::get('/cta-sections', function () {
        return CtaSection::all();
    });

    // ==========================================
    // 客户线索管理
    // ==========================================
    
    /**
     * 提交客户线索
     * POST /api/leads
     * 
     * 请求体:
     * {
     *   "name": "客户名称",
     *   "contact": "13800138000",
     *   "message": "需求描述",
     *   "source": "来源渠道"
     * }
     */
    Route::post('/leads', function (Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'contact' => 'required|string|max:255',
            'message' => 'nullable|string',
            'source' => 'nullable|string|max:100',
        ]);

        return Lead::create($validated);
    });

    /**
     * 获取所有客户线索（管理员）
     * GET /api/leads
     * 支持参数: ?status=0&page=1&per_page=20
     */
    Route::get('/leads', function (Request $request) {
        $query = Lead::latest();
        
        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }
        
        return $query->paginate($request->get('per_page', 20));
    })->middleware('auth:sanctum'); // 可选：添加认证保护

    /**
     * 获取单个客户线索详情
     * GET /api/leads/{id}
     */
    Route::get('/leads/{id}', function ($id) {
        return Lead::findOrFail($id);
    })->middleware('auth:sanctum');

    /**
     * 更新客户线索状态
     * PUT /api/leads/{id}
     * 
     * 请求体:
     * {
     *   "status": 1
     * }
     */
    Route::put('/leads/{id}', function (Request $request, $id) {
        $lead = Lead::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'sometimes|in:0,1,2,3',
            'message' => 'sometimes|string',
        ]);
        
        $lead->update($validated);
        
        return $lead;
    })->middleware('auth:sanctum');

    /**
     * 删除客户线索
     * DELETE /api/leads/{id}
     */
    Route::delete('/leads/{id}', function ($id) {
        $lead = Lead::findOrFail($id);
        $lead->delete();
        
        return response()->json(['message' => '删除成功']);
    })->middleware('auth:sanctum');

});
