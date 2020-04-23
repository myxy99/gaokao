<?php

namespace App\Admin\Actions\Post;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class BatchRestore extends BatchAction
{
    public $name = '恢复';

    public function handle(Collection $collection)
    {
        $collection->each->restore();

        return $this->response()->success('已恢复')->refresh();
    }

    public function dialog()
    {
        $this->confirm('确定恢复吗？');
    }
}