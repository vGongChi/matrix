<?php

namespace App\Admin\Controllers;

use App\Models\HeroSection;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class HeroSectionController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Hero区域';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new HeroSection());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('title', __('主标题'));
        $grid->column('highlight_text', __('高亮文字'));
        $grid->column('subtitle', __('副标题'))->limit(50);
        $grid->column('image', __('图片'))->image('', 50, 50);
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
        $show = new Show(HeroSection::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('title', __('主标题'));
        $show->field('highlight_text', __('高亮文字'));
        $show->field('subtitle', __('副标题'));
        $show->field('image', __('图片'))->image();
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
        $form = new Form(new HeroSection());

        $form->text('title', __('主标题'))->required();
        $form->text('highlight_text', __('高亮文字'));
        $form->textarea('subtitle', __('副标题'));
        $form->image('image', __('图片'))->rules('required|image');

        return $form;
    }
}
