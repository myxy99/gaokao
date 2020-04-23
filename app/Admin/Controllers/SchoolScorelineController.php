<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\BatchRestore;
use App\Admin\Actions\Post\Restore;
use App\Models\Batch;
use App\Models\Project;
use App\Models\Province;
use App\Models\School;
use App\Models\SchoolScoreline;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SchoolScorelineController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '学校分数线管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SchoolScoreline());
        $grid->id('id')->sortable()->hide();
        $grid->filter(function ($filter) {
            $filter->column(1/3, function ($filter) {
                $filter->disableIdFilter();
                $filter->scope('trashed', '回收站')->onlyTrashed();
                $filter->like('year', '年份');
                $filter->where(function ($query) {
                    $query->whereHas('school', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%");
                    });
                }, '学校名称');
            });
            $filter->column(1/3, function ($filter) {
                $filter->like('majar', '专业名称');
                $filter->where(function ($query) {
                    $query->whereHas('province', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%");
                    });
                }, '省份');
            });
            $filter->column(1/3, function ($filter) {
                $filter->where(function ($query) {
                    $query->whereHas('project', function ($query) {
                        $query->where('project_name', 'like', "%{$this->input}%");
                    });
                }, '科类');
                $filter->where(function ($query) {
                    $query->whereHas('batch', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%");
                    });
                }, '批次');
            });

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
        $grid->column('school_code', __('学校名称'))->display(function ($school_code) {
            $data = $school_code != null ? School::where('code', $school_code)->first() : null;
            return $data != null ? $data->name : null;
        });
        $grid->column('year', __('年份'));
        $grid->column('province_id', __('省份'))->display(function ($province_id) {
            $data = $province_id != null ? Province::find($province_id) : null;
            return $data != null ? $data->name : null;
        });
        $grid->column('project_id', __('科类'))->display(function ($project_id) {
            $data = $project_id != null ? Project::find($project_id) : null;
            return $data != null ? $data->project_name : null;
        });
        $grid->column('majar', __('专业'));
        $grid->column('batch_id', __('批次'))->display(function ($batch_id) {
            $data = $batch_id != null ? Batch::find($batch_id) : null;
            return $data != null ? $data->name : null;
        });
        $grid->column('max', __('最高分'));
        $grid->column('min', __('最低分'));
        $grid->column('aver', __('平均分'));
        $grid->column('forecast', __('预测分数'));
        $grid->column('created_at', __('创建时间'))->hide();
        $grid->column('updated_at', __('更新时间'))->hide();

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
        $show = new Show(SchoolScoreline::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('school_code', __('学校'))->as(function ($school_code) {
            $data = $school_code != null ? School::where('code', $school_code)->first() : null;
            return $data != null ? $data->name : null;
        });
        $show->field('year', __('年份'));
        $show->field('majar', __('专业'));
        $show->field('province_id', __('省份'))->as(function ($province_id) {
            $data = $province_id != null ? Province::find($province_id) : null;
            return $data != null ? $data->name : null;
        });;
        $show->field('project_id', __('科类'))->as(function ($project_id) {
            $data = $project_id != null ? Project::find($project_id) : null;
            return $data != null ? $data->project_name : null;
        });;
        $show->field('batch_id', __('批次'))->as(function ($batch_id) {
            $data = $batch_id != null ? Batch::find($batch_id) : null;
            return $data != null ? $data->name : null;
        });;
        $show->field('max', __('最高分'));
        $show->field('min', __('最低分'));
        $show->field('aver', __('平均分'));
        $show->field('forecast', __('预测分数'));
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
        $form = new Form(new SchoolScoreline());

        $form->select('school_code', __('学校'))->options(function ($id) {
            $data = $id != null ? School::where('code', $id)->first() : null;
            if ($data != null) {
                return [$data->id => $data->name];
            }
        })->ajax('/admin/api/school')->rules('required');

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
        $form->date('year', __('年份'))->format('YYYY')->required();
        $form->text('majar', __('专业'))->rules('required')->required();
        $form->disableReset();
        $form->text('max', __('最高分'))->rules('numeric');
        $form->text('min', __('最低分'))->rules('numeric');
        $form->text('aver', __('平均分'))->rules('numeric');
        $form->text('forecast', __('预测分数'))->rules('numeric');

        return $form;
    }
}
