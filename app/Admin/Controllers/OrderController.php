<?php

namespace App\Admin\Controllers;

use App\Models\Order;
use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrderController extends AdminController
{
    protected $title = '智作·快反订单';

    protected function grid()
    {
        $grid = new Grid(new Order());

        $grid->column('id', 'ID')->sortable();
        $grid->column('order_no', '订单号');
        $grid->column('user.name', '客户');
        $grid->column('product.name', '商品');
        $grid->column('status', '状态')->using(Order::getStatuses())->label([
            'pending_deposit' => 'default',
            'processing' => 'info',
            'pending_final' => 'warning',
            'completed' => 'success',
            'after_sale' => 'danger',
            'cancelled' => 'secondary',
        ]);
        $grid->column('deposit_paid', '启动金')->switch();
        $grid->column('final_paid', '尾款')->switch();
        $grid->column('total_price', '总价');
        $grid->column('created_at', '创建时间')->sortable();

        $grid->filter(function ($filter) {
            $filter->like('order_no', '订单号');
            $filter->equal('status', '状态')->select(Order::getStatuses());
        });

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('order_no', '订单号');
        $show->field('user.name', '客户');
        $show->field('product.name', '商品');
        $show->field('status', '状态')->using(Order::getStatuses());
        $show->field('total_price', '总价');
        $show->field('deposit_amount', '启动金金额');
        $show->field('final_amount', '尾款金额');
        $show->field('deposit_paid', '启动金已付')->bool();
        $show->field('final_paid', '尾款已付')->bool();
        $show->field('is_jumped', '是否跳阶')->bool();
        $show->field('jump_message', '跳阶提示');
        $show->field('requirements', '需求表单')->json();
        $show->field('tech_stack', '技术栈')->json();
        $show->field('preview_files', '预览文件')->json();
        $show->field('delivery_files', '交付物')->json();
        $show->field('agreed_third_party', '三方免责协议')->bool();
        $show->field('customer_notes', '客户备注');
        $show->field('admin_notes', '管理员备注');
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '更新时间');

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Order());

        $form->select('user_id', '客户')->options(function ($id) {
            $user = \App\Models\User::find($id);
            return $user ? [$user->id => $user->name ?: $user->email] : [];
        })->ajax('/admin/api/users');
        $form->select('product_id', '商品')->options(function ($id) {
            $product = Product::find($id);
            return $product ? [$product->id => $product->name] : [];
        })->ajax('/admin/api/products');
        $form->text('order_no', '订单号')->readonly();
        $form->select('status', '状态')->options(Order::getStatuses());
        $form->decimal('total_price', '总价')->required();
        $form->decimal('deposit_amount', '启动金金额')->required();
        $form->decimal('final_amount', '尾款金额')->required();
        $form->switch('deposit_paid', '启动金已付')->default(false);
        $form->switch('final_paid', '尾款已付')->default(false);
        $form->switch('is_jumped', '是否跳阶')->default(false);
        $form->text('jump_message', '跳阶提示');
        $form->textarea('requirements', '需求表单')->rows(8);
        $form->textarea('tech_stack', '技术栈')->rows(5);
        $form->textarea('preview_files', '预览文件')->rows(5);
        $form->textarea('delivery_files', '交付物')->rows(5);
        $form->switch('agreed_third_party', '三方免责协议')->default(false);
        $form->textarea('customer_notes', '客户备注')->rows(4);
        $form->textarea('admin_notes', '管理员备注')->rows(4);

        return $form;
    }
}
