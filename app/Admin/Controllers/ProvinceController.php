<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\BatchRestore;
use App\Admin\Actions\Post\Restore;
use App\Models\Province;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProvinceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '省份管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Province());
        $grid->id('id')->sortable()->hide();
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->scope('trashed', '回收站')->onlyTrashed();
            $filter->like('name', '省份名称');
            $filter->like('form', '模拟填报地址');
        });
        $grid->actions(function ($actions) {
            if (\request('_scope_') == 'trashed') {
                $actions->add(new Restore());
            }
        });
        $grid->batchActions(function ($batch) {
            if (\request('_scope_') == 'trashed') {
                $batch->add(new BatchRestore());
            }
        });
        $grid->column('name', __('省份名称'));
        $grid->column('form', __('模拟填报地址'));
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Province::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('省份名称'));
        $show->field('form', __('模拟填报地址'));
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
        $form = new Form(new Province());
        $form->disableReset();
        $form->text('name', __('名称'))->rules('required')->required();
        $form->file('form', __('模拟填报HTML'))->move('/html')->rules('mimes:html');

        return $form;
    }
}
