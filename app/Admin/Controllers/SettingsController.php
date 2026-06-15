<?php

namespace App\Admin\Controllers;

use App\Models\Settings;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SettingsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '网站配置';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Settings());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('site_name', __('网站中文名称'));
        $grid->column('site_name_en', __('网站英文名称'));
        $grid->column('logo', __('Logo'))->image('', 50, 50);
        $grid->column('phone', __('联系电话'));
        $grid->column('email', __('邮箱'));
        $grid->column('address', __('地址'));
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
        $show = new Show(Settings::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('site_name', __('网站中文名称'));
        $show->field('site_name_en', __('网站英文名称'));
        $show->field('logo', __('Logo'))->image();
        $show->field('phone', __('联系电话'));
        $show->field('email', __('邮箱'));
        $show->field('address', __('地址'));
        $show->field('wechat_qr', __('微信二维码'))->image();
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
        $form = new Form(new Settings());

        $form->text('site_name', __('网站中文名称'))->required();
        $form->text('site_name_en', __('网站英文名称'));
        $form->image('logo', __('Logo'))->rules('required|image');
        $form->text('phone', __('联系电话'));
        $form->email('email', __('邮箱'));
        $form->text('address', __('地址'));
        $form->image('wechat_qr', __('微信二维码'))->rules('image');

        return $form;
    }
}
