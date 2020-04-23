<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Post\BatchRestore;
use App\Admin\Actions\Post\Restore;
use App\Models\Batch;
use App\Models\Province;
use App\Models\School;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SchoolController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '学校管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new School());
        $grid->id('id')->sortable()->hide();
        $grid->filter(function ($filter) {
            $filter->scope('trashed', '回收站')->onlyTrashed();
            $filter->disableIdFilter();
            $filter->like('code', '学校标识码');
            $filter->like('name', '学校名称');
            $filter->where(function ($query) {
                $query->whereHas('profile', function ($query) {
                    $query->where('name', 'like', "%{$this->input}%");
                });
            }, '省份');
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

        $grid->column('code', __('学校标识码'));

        $grid->column('province_id', __('省份'))->display(function ($province_id) {
            $data = $province_id != null ? Province::find($province_id) : null;
            return $data != null ? $data->name : null;
        });

        $grid->column('batch_id', __('批次'))->display(function ($batch_id) {
            $data = $batch_id != null ? Batch::find($batch_id) : null;
            return $data != null ? $data->name : null;
        });

        $grid->column('name', __('名称'));
        $grid->column('web1', __('学校官网'))->width(350)->display(function ($url) {
            return "<a href='$url' target='view_window'>$url</a>";
        });
        $grid->column('web2', __('学校本科生招生官网'))->width(350)->display(function ($url) {
            return "<a href='$url' target='view_window'>$url</a>";
        });
        $grid->column('web3', __('录取查询官网'))->width(350)->display(function ($url) {
            return "<a href='$url' target='view_window'>$url</a>";
        });
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
        $show = new Show(School::findOrFail($id));

        $show->field('code', __('学校标识码'));
        $show->field('name', __('名称'));
        $show->field('province_id', __('省份'))->as(function ($province_id) {
            $data = $province_id != null ? Province::find($province_id) : null;
            return $data != null ? $data->name : null;
        });
        $show->field('batch_id', __('批次'))->as(function ($batch_id) {
            $data = $batch_id != null ? Batch::find($batch_id) : null;
            return $data != null ? $data->name : null;
        });
        $show->field('web1', __('学校官网'));
        $show->field('web2', __('学校本科生招生官网'));
        $show->field('web3', __('录取查询官网'));
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
        $form = new Form(new School());
        $form->disableReset();
        $form->text('code', __('学校标识码'))->rules('required')->creationRules(['required', "unique:school", "numeric"])->required();
        $form->text('name', __('名称'))->rules('required')->required();
        $form->url('web1', __('学校官网'))->rules('required')->required();
        $form->url('web2', __('学校本科生招生官网'))->rules('required')->required();
        $form->url('web3', __('录取查询官网'))->rules('required')->required();
        $form->select('province_id', __('省份'))->options(function ($id) {
            $data = $id != null ? Province::find($id) : null;
            if ($data != null) {
                return [$data->id => $data->name];
            }
        })->ajax('/admin/api/province')->rules('required');
        $form->select('batch_id', __('批次'))->options(function ($batch_id) {
            $batch = $batch_id != null ? Batch::find($batch_id) : null;
            if ($batch != null) {
                return [$batch->id => $batch->name];
            }
        })->ajax('/admin/api/batch')->rules('required');
        return $form;
    }
}
