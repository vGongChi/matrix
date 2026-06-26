<?php

namespace App\Admin\Controllers;

use App\Models\Material;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class MaterialController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '素材管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Material());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('title', __('标题'));
        $grid->column('type', __('类型'))->using(Material::getTypes())->label([
            'image' => 'primary',
            'video' => 'success',
            'text' => 'info',
            'code' => 'warning',
        ]);
        $grid->column('description', __('描述'))->limit(50);
        $grid->column('thumbnail', __('缩略图'))->image(null, 40);
        $grid->column('sort', __('排序'))->sortable();
        $grid->column('is_active', __('启用'))->switch();
        $grid->column('created_at', __('创建时间'))->sortable();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Material::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('title', __('标题'));
        $show->field('type', __('类型'))->using(Material::getTypes());
        $show->field('description', __('描述'));
        $show->field('thumbnail', __('缩略图'))->image();
        
        $show->field('image_url', __('图片'))->as(function ($value) {
            if (is_array($value)) {
                $images = $value;
            } else {
                $images = json_decode($value, true);
                if (!is_array($images)) {
                    $images = $value ? [$value] : [];
                }
            }

            if (empty($images)) {
                return '-';
            }

            return collect($images)->map(function ($path) {
                return "<img src=\"/storage/admin/{$path}\" style=\"max-width: 120px; margin-right: 8px; margin-bottom: 8px;\" />";
            })->implode('');
        })->unescape();
        $show->field('video_url', __('视频URL'));
        $show->field('text_content', __('文字内容'));
        $show->field('code_content', __('代码内容'))->code();
        $show->field('code_language', __('代码语言'));
        $show->field('code_repo_url', __('代码仓库地址'));
        
        $show->field('sort', __('排序'));
        $show->field('is_active', __('启用'));
        $show->field('created_at', __('创建时间'));
        $show->field('updated_at', __('更新时间'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Material());

        $form->text('title', __('素材标题'))->required();
        $form->select('type', __('素材类型'))->options(Material::getTypes())->required()
            ->help('选择素材类型后，对应的字段会自动显示');
        $form->textarea('description', __('素材描述'))->rows(3)->placeholder('简短的素材描述或说明');
        
        $form->image('thumbnail', __('封面缩略图'))->required()
            ->help('建议尺寸：800x600 或 16:9 比例');

        // 图片类型字段
        $form->multipleImage('image_url', __('图片'))->removable()
            ->help('支持多张图片，第一张为主图');

        // 视频类型字段
        $form->file('video_url', __('视频'))->removable()
            ->help('支持 MP4、WebM、AVI 等视频格式，可上传大文件');

        // 文字类型字段
        $form->textarea('text_content', __('文字内容'))->rows(8)
            ->placeholder('输入文字内容，支持 Markdown 格式');

        // 代码类型字段
        $form->textarea('code_content', __('代码内容'))->rows(10)
            ->placeholder('粘贴代码内容');
        $form->text('code_language', __('代码语言'))->placeholder('例如：php, javascript, python, html 等');
        $form->url('code_repo_url', __('代码仓库地址（可掩饰）'))->placeholder('GitHub 或其他代码托管地址');

        $form->number('sort', __('排序'))->default(0)->help('数字越小排序越靠前');
        $form->switch('is_active', __('启用'))->default(true);

        return $form;
    }
}
