<?php

namespace App\Admin\Controllers;

use App\Models\Team;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TeamController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '团队管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Team());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('成员名字'));
        $grid->column('nickname', __('昵称'));
        $grid->column('position', __('岗位职责'))->limit(30);
        $grid->column('images', __('图片'))->display(function ($images) {
            if (is_array($images) && !empty($images)) {
                return '<img src="' . $images[0] . '" style="max-height: 40px;" />';
            }
            return '-';
        });
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
        $show = new Show(Team::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('成员名字'));
        $show->field('nickname', __('昵称'));
        $show->field('position', __('岗位职责'));
        $show->field('description', __('文字介绍'));
        $show->field('images', __('图片'))->image();
        $show->field('video_url', __('视频介绍地址'));
        $show->field('audio_url', __('音频介绍地址'));
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
        $form = new Form(new Team());

        $form->text('name', __('成员名字'))->required();
        $form->text('nickname', __('昵称'))->placeholder('例如：昵称或技能标签');
        $form->textarea('position', __('岗位职责'))->rows(4)->placeholder('例如：前端开发、UI设计、项目管理等');
        $form->textarea('description', __('文字介绍'))->rows(6)->placeholder('详细的个人介绍和专业经历');

        // 图片数组处理
        $form->multipleImage('images', __('成员图片'))->removable()->help('支持多张图片，第一张为主图');

        $form->url('video_url', __('视频介绍地址'))->placeholder('例如：https://example.com/video.mp4');
        $form->url('audio_url', __('音频介绍地址'))->placeholder('例如：https://example.com/audio.mp3');

        $form->number('sort', __('排序'))->default(0)->help('数字越小，排序越靠前');
        $form->switch('is_active', __('启用'))->default(true);

        return $form;
    }
}
