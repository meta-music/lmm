<?php

namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Http\Controllers\Controller;
use Dcat\Admin\Http\Controllers\Dashboard;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('Dashboard')
            ->description('心情&情绪相关的统计图表, 考虑后面再加个情绪任务/成就徽章之类的, 目前为Demo数据, 待讨论')
            ->body(function (Row $row) {
                // $row->column(6, function (Column $column) {
                //     $column->row(Dashboard::title());
                //     $column->row(new Examples\Tickets());
                // });

                $row->column(12, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(6, new Examples\NewUsers());
                        $row->column(6, new Examples\NewDevices());
                    });
                    $column->row(function (Row $row) {
                        $row->column(6, new Examples\Sessions());
                        $row->column(6, new Examples\ProductOrders());
                    });

                });
            });
    }
}
