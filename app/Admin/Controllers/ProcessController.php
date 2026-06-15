<?php

namespace App\Admin\Controllers;

use App\Models\Process;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProcessController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '合作流程';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Process());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('step', __('步骤序号'))->sortable();
        $grid->column('title', __('标题'));
        $grid->column('description', __('描述'))->limit(50);
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
        $show = new Show(Process::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('step', __('步骤序号'));
        $show->field('title', __('标题'));
        $show->field('description', __('描述'));
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
        $form = new Form(new Process());

        $form->number('step', __('步骤序号'))->required();
        $form->text('title', __('标题'))->required();
        $form->textarea('description', __('描述'));

        return $form;
    }
}
