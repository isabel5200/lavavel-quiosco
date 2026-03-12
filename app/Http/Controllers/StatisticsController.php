<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function bestSellingProducts()
    {
        $data = DB::table('orders as o')
            ->join('order_products as op', 'op.order_id', '=', 'o.id')
            ->join('products as p', 'p.id', '=', 'op.product_id')
            ->join('categories as c', 'c.id', '=', 'p.category_id')
            ->select('c.name as category', DB::raw('SUM(op.quantity) as total_sold'))
            ->groupBy('c.id', 'c.name')
            ->get();

        return response()->json($data);
    }

    public function earningsByCategory()
    {
        $data = DB::table('orders as o')
            ->join('order_products as op', 'op.order_id', '=', 'o.id')
            ->join('products as p', 'p.id', '=', 'op.product_id')
            ->join('categories as c', 'c.id', '=', 'p.category_id')
            ->select('c.name as category', DB::raw('SUM(op.quantity * p.price) as total_earnings'))
            ->groupBy('c.id', 'c.name')
            ->get();

        return response()->json($data);
    }
}
