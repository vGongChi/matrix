<?php

namespace App\Admin\Controllers;

use App\Models\HeroFeature;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HeroFeatureController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Hero卖点';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HeroFeature());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('icon', __('图标'));
        $grid->column('text', __('描述'));
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
        $show = new Show(HeroFeature::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('icon', __('图标'));
        $show->field('text', __('描述'));
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
        $form = new Form(new HeroFeature());

        $form->text('icon', __('图标（iconify）'))->placeholder('例：mdi:home')->required();
        $form->text('text', __('描述'))->required();
        $form->number('sort', __('排序'))->default(0);

        return $form;
    }
}
