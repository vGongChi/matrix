<?php

namespace App\Admin\Controllers;

use App\Models\Service;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ServiceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '服务管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Service());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('title', __('服务名称'));
        $grid->column('description', __('服务描述'))->limit(50);
        $grid->column('icon', __('图标'));
        $grid->column('sort', __('排序'))->sortable();
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
        $show = new Show(Service::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('title', __('服务名称'));
        $show->field('description', __('服务描述'));
        $show->field('icon', __('图标'));
        $show->field('sort', __('排序'));
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
        $form = new Form(new Service());

        $form->text('title', __('服务名称'))->required();
        $form->textarea('description', __('服务描述'));
        $form->text('icon', __('图标（iconify）'))->placeholder('例：mdi:cog')->required();
        $form->number('sort', __('排序'))->default(0);

        return $form;
    }
}
