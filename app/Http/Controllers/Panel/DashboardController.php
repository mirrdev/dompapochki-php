<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Models\Order;
use App\Http\Models\Product;

class DashboardController extends Controller
{
    // space that we can use the repository from
    protected $model;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $months = Order::getMonthsSortString('-1 YEAR');
        $year = Order::getSumPeriod('-1 YEAR', 'MONTH');
        $month = Order::getSumPeriod('-30 DAY', 'DAY');
        $weak = Order::getSumPeriod('-7 DAY', 'DAY');
        $day20 = Order::getSumPeriod('-20 DAY', 'DAY');

        $data = [
            'info' => [
                'countProducts' => Product::count(),
                'countOrders' => Order::count(),
            ],
            'sum' => [
                'all' => Order::returnSumAll(),
                'month' => Order::returnSum($month),
                'weak' => Order::returnSum($weak),
            ],
            'data' => [
                'months' => $months,
                'year' => Order::getSumString($year),
                'month' => Order::getSumString($month),
                'weak' => Order::getSumString($weak),
                'day20' => Order::getSumString($day20)
            ]
        ];
        return view('dashboard/v1', $data);
    }
}
