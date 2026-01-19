<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function map()
    {
        // Group orders by province_id and count them, joining with provinces table to get English name
        $provinceData = Order::select('provinces.name_en as province', DB::raw('count(*) as count'))
            ->join('provinces', 'orders.province_id', '=', 'provinces.id')
            ->whereNotNull('orders.province_id')
            ->groupBy('provinces.name_en')
            ->get();

        return view('admin.analytics.map', compact('provinceData'));
    }
}
