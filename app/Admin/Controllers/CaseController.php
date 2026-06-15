<?php

namespace App\Admin\Controllers;

use App\Models\Case_;
use App\Models\CaseTag;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CaseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '案例管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Case_());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('title', __('案例标题'));
        $grid->column('cover', __('封面图'))->image('', 50, 50);
        $grid->column('description', __('描述'))->limit(50);
        $grid->column('result', __('成果说明'))->limit(50);
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
        $show = new Show(Case_::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('title', __('案例标题'));
        $show->field('cover', __('封面图'))->image();
        $show->field('description', __('案例描述'));
        $show->field('result', __('成果说明'));
        $show->field('tags', __('标签'))->relation('tags', 'name');
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
        $form = new Form(new Case_());

        $form->text('title', __('案例标题'))->required();
        $form->image('cover', __('封面图'))->rules('required|image');
        $form->textarea('description', __('案例描述'));
        $form->text('result', __('成果说明'));
        
        $form->multipleSelect('tags', __('标签'))
            ->options(CaseTag::pluck('name', 'id'));

        return $form;
    }
}
