<?php

namespace App\Admin\Controllers;

use App\Models\AfterSaleRequest;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AfterSaleRequestController extends AdminController
{
    protected $title = '售后工单';

    protected function grid()
    {
        $grid = new Grid(new AfterSaleRequest());

        $grid->column('id', 'ID')->sortable();
        $grid->column('order.order_no', '订单号');
        $grid->column('user.name', '客户');
        $grid->column('request_type', '类型')->using(AfterSaleRequest::getRequestTypes());
        $grid->column('status', '状态')->using(AfterSaleRequest::getStatuses())->label([
            'pending' => 'default',
            'processing' => 'info',
            'resolved' => 'success',
            'closed' => 'secondary',
        ]);
        $grid->column('created_at', '创建时间')->sortable();

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(AfterSaleRequest::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('order.order_no', '订单号');
        $show->field('user.name', '客户');
        $show->field('request_type', '类型')->using(AfterSaleRequest::getRequestTypes());
        $show->field('description', '问题描述');
        $show->field('attachments', '附件')->json();
        $show->field('status', '状态')->using(AfterSaleRequest::getStatuses());
        $show->field('admin_response', '管理员回复');
        $show->field('response_files', '回复附件')->json();
        $show->field('resolved_at', '解决时间');
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '更新时间');

        return $show;
    }

    protected function form()
    {
        $form = new Form(new AfterSaleRequest());

        $form->select('order_id', '订单')->options(function ($id) {
            $order = \App\Models\Order::find($id);
            return $order ? [$order->id => $order->order_no] : [];
        })->ajax('/admin/api/orders');
        $form->select('user_id', '客户')->options(function ($id) {
            $user = \App\Models\User::find($id);
            return $user ? [$user->id => $user->name ?: $user->email] : [];
        })->ajax('/admin/api/users');
        $form->select('request_type', '工单类型')->options(AfterSaleRequest::getRequestTypes());
        $form->textarea('description', '问题描述')->required()->rows(6);
        $form->textarea('attachments', '附件')->rows(4);
        $form->select('status', '状态')->options(AfterSaleRequest::getStatuses());
        $form->textarea('admin_response', '管理员回复')->rows(4);
        $form->textarea('response_files', '回复附件')->rows(4);
        $form->datetime('resolved_at', '解决时间');

        return $form;
    }
}
