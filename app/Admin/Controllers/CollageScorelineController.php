<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\BatchRestore;
use App\Admin\Actions\Post\Restore;
use App\Models\Batch;
use App\Models\CollageScoreline;
use App\Models\Project;
use App\Models\Province;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CollageScorelineController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '省份高考分数线管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CollageScoreline());
        $grid->id('id')->sortable()->hide();
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->scope('trashed', '回收站')->onlyTrashed();
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
        $grid->column('year', __('年份'));
        $grid->column('province_id', __('省份'))->display(function ($province_id) {
            $data = $province_id != null ? Province::find($province_id) : null;
            return $data != null ? $data->name : null;
        });
        $grid->column('project_id', __('科类名称'))->display(function ($project_id) {
            $data = $project_id != null ? Project::find($project_id) : null;
            return $data != null ? $data->project_name : null;
        });
        $grid->column('batch_id', __('批次名称'))->display(function ($batch_id) {
            $data = $batch_id != null ? Batch::find($batch_id) : null;
            return $data != null ? $data->name : null;
        });
        $grid->column('score', __('分数'));
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
        $show = new Show(CollageScoreline::findOrFail($id));

        $show->field('id', __('Id'));

        $show->field('province_id', __('省份'))->as(function ($province_id) {
            $data = $province_id != null ? Province::find($province_id) : null;
            return $data != null ? $data->name : null;
        });

        $show->field('project_id', __('科类名称'))->as(function ($data_id) {
            $data = $data_id != null ? Project::find($data_id) : null;
            return $data != null ? $data->project_name : null;
        });
        $show->field('batch_id', __('批次名称'))->as(function ($data_id) {
            $data = $data_id != null ? Batch::find($data_id) : null;
            return $data != null ? $data->name : null;
        });
        $show->field('score', __('分数'));
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
        $form = new Form(new CollageScoreline());
        $form->disableReset();
        $form->date('year', __('年份'))->format('YYYY')->rules('required')->required();
        $form->select('province_id', __('省份'))->options(function ($id) {
            $data = $id != null ? Province::find($id) : null;
            if ($data) {
                return [$data->id => $data->name];
            }
        })->ajax('/admin/api/province')->rules('required');

        $form->select('project_id', __('科类'))->options(function ($id) {
            $data = $id != null ? Project::find($id) : null;
            if ($data) {
                return [$data->id => $data->project_name];
            }
        })->ajax('/admin/api/project')->rules('required');

        $form->select('batch_id', __('批次'))->options(function ($id) {
            $batch = $id != null ? Batch::find($id) : null;
            if ($batch) {
                return [$batch->id => $batch->name];
            }
        })->ajax('/admin/api/batch')->rules('required');

        $form->text('score', __('分数'))->rules('required|numeric')->required();

        return $form;
    }
}
