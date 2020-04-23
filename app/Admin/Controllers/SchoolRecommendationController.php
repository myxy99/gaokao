<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\BatchRestore;
use App\Admin\Actions\Post\Restore;
use App\Models\School;
use App\Models\SchoolRecommendation;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SchoolRecommendationController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '学校推荐管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SchoolRecommendation());

        $grid->id('id')->sortable()->hide();
        $grid->filter(function ($filter) {
            $filter->disableIdFilter();
            $filter->scope('trashed', '回收站')->onlyTrashed();
            $filter->where(function ($query) {
                $query->whereHas('profile', function ($query) {
                    $query->where('name', 'like', "%{$this->input}%");
                });
            }, '学校名称');
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

        $grid->column('school_code', __('学校名称'))->display(function ($data) {
            $data = $data != null ? School::where('code', $data)->first() : null;
            return $data != null ? $data->name : null;
        });
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
        $show = new Show(SchoolRecommendation::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('school_code', __('学校编号'));
        $show->field('school_code', __('学校名称'))->as(function ($data) {
            $data = $data != null ? School::where('code', $data)->first() : null;
            return $data != null ? $data->name : null;
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
        $form = new Form(new SchoolRecommendation());

        $form->select('school_code', __('学校'))->options(function ($id) {
            $data = $id != null ? School::where('code', $id)->first() : null;
            if ($data != null) {
                return [$data->id => $data->name];
            }
        })->ajax('/admin/api/school')->rules('required');

        return $form;
    }
}
