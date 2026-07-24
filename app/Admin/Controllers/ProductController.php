<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductController extends AdminController
{
    protected $title = '智作·快反商品';

    protected function grid()
    {
        $grid = new Grid(new Product());

        $grid->column('id', 'ID')->sortable();
        $grid->column('name', '商品名称');
        $grid->column('level', '难度')->using(Product::getLevels());
        $grid->column('deposit_rate', '启动金比例(%)');
        $grid->column('price', '基准总价');
        $grid->column('jump_fee_penalty', '跳阶加收(%)');
        $grid->column('max_revisions', '免费修改次数');
        $grid->column('status', '上架状态')->switch();
        $grid->column('created_at', '创建时间')->sortable();

        $grid->filter(function ($filter) {
            $filter->like('name', '商品名称');
            $filter->equal('status', '状态')->radio([
                '' => '全部',
                1 => '上架',
                0 => '下架',
            ]);
        });

        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(Product::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('name', '商品名称');
        $show->field('level', '难度')->using(Product::getLevels());
        $show->field('deposit_rate', '启动金比例(%)');
        $show->field('price', '基准总价');
        $show->field('depend_product_id', '前置依赖商品ID');
        $show->field('jump_fee_penalty', '跳阶加收(%)');
        $show->field('max_revisions', '免费修改次数');
        $show->field('requires_tech_stack', '需要技术栈')->using([0 => '否', 1 => '是']);
        $show->field('demo_images', '参考图')->as(function ($value) {
            if (empty($value)) {
                return '-';
            }

            return implode(', ', (array) $value);
        });
        $show->field('status', '上架状态')->using([0 => '下架', 1 => '上架']);
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '更新时间');

        return $show;
    }

    protected function form()
    {
        $form = new Form(new Product());

        $form->text('name', '商品名称')->required();
        $form->select('level', '难度等级')->options(Product::getLevels())->required();
        $form->decimal('deposit_rate', '启动金比例(%)')->default(30)->required();
        $form->decimal('price', '基准总价')->required();
        $form->select('depend_product_id', '前置依赖商品')->options(function ($id) {
            $product = Product::find($id);
            if ($product) {
                return [$product->id => $product->name];
            }
            return [];
        })->ajax('/admin/api/products');
        $form->decimal('jump_fee_penalty', '跳阶加收比例(%)')->default(25)->required();
        $form->number('max_revisions', '免费修改次数')->default(2)->required();
        $form->switch('requires_tech_stack', '是否需要技术栈')->default(false);
        $form->multipleImage('demo_images', '参考图')->removable();
        $form->switch('status', '上架')->default(true);

        return $form;
    }
}
