<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\BatchRestore;
use App\Admin\Actions\Post\Restore;
use App\Models\Batch;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BatchController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '批次管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Batch());
        $grid->id('id')->sortable()->hide();
        $grid->filter(function ($filter) {
            $filter->scope('trashed', '回收站')->onlyTrashed();
            $filter->disableIdFilter();
            $filter->like('name', '批次名称');
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
        $grid->column('name', __('批次名称'));
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
        $show = new Show(Batch::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('批次名称'));
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
        $form = new Form(new Batch());
        $form->disableReset();
        $form->text('name', __('批次名称'))->rules('required')->required();

        return $form;
    }
}
