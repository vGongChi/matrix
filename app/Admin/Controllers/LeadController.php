<?php

namespace App\Admin\Controllers;

use App\Models\Lead;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class LeadController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '客户线索';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Lead());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('客户姓名'));
        $grid->column('contact', __('联系方式'));
        $grid->column('message', __('需求内容'))->limit(50);
        $grid->column('source', __('来源渠道'));
        $grid->column('status', __('状态'))
            ->dot([
                0 => 'warning',
                1 => 'info',
                2 => 'success',
                3 => 'danger',
            ], [
                0 => '未处理',
                1 => '已联系',
                2 => '已成交',
                3 => '无效',
            ]);
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
        $show = new Show(Lead::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('客户姓名'));
        $show->field('contact', __('联系方式'));
        $show->field('message', __('需求内容'));
        $show->field('source', __('来源渠道'));
        $show->field('status', __('状态'))->as(function($value) {
            return match($value) {
                0 => '未处理',
                1 => '已联系',
                2 => '已成交',
                3 => '无效',
                default => '未知',
            };
        });
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
        $form = new Form(new Lead());

        $form->display('id', __('ID'));
        $form->text('name', __('客户姓名'))->required();
        $form->text('contact', __('联系方式'))->required();
        $form->textarea('message', __('需求内容'));
        $form->text('source', __('来源渠道'))->placeholder('如：百度、谷歌、微信等');
        $form->select('status', __('状态'))
            ->options([
                0 => '未处理',
                1 => '已联系',
                2 => '已成交',
                3 => '无效',
            ])
            ->default(0);
        $form->display('created_at', __('创建时间'));
        $form->display('updated_at', __('更新时间'));

        return $form;
    }
}
