<?php

namespace App\Admin\Extensions;


class Select extends \Encore\Admin\Form\Field\Select
{
    /**
     * @var array
     */
    protected static $js = [
        '/vendor/laravel-admin/AdminLTE/plugins/select2/i18n/zh-CN.js',
    ];

}