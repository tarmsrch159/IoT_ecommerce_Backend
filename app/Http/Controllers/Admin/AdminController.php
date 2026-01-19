<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //

    public function index()
    {
        $todayOrders = Order::whereDay('created_at', Carbon::today())->get();
        $yesterdayOrders = Order::whereDay('created_at', Carbon::yesterday())->get();
        $monthOrders = Order::whereMonth('created_at', Carbon::now()->month)->count();
        $yearOrders = Order::whereYear('created_at', Carbon::now()->year)->count();
        $products = Product::with(['category'])
            ->leftJoin('order_product', 'products.id', '=', 'order_product.product_id')
            ->select(
                'products.*',
                DB::raw('COUNT(order_product.id) as total_sold')
            )
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->limit(8)
            ->get();

        $lowStockProducts = Product::with(['category'])
            ->where('qty', '<=', 5)
            ->orderBy('qty', 'asc')
            ->limit(10)
            ->get();


        return view('admin.dashboard')->with([
            'todayOrders' => $todayOrders,
            'yesterdayOrders' => $yesterdayOrders,
            'monthOrders' => $monthOrders,
            'yearOrders' => $yearOrders,
            'totalPrice' => Order::where('status', 'delivered')->sum('total'),
            'totalProducts' => Product::count(),
            'totalOrders' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'deliveredOrders' => Order::where('status', 'delivered')->count(),
            'cancelledOrders' => Order::where('status', 'cancelled')->count(),
            'bestSellingProducts' => $products,
            'lowStockProducts' => $lowStockProducts,
        ]);
    }

    public function login()
    {
        return view('login');
    }

    public function auth(AdminRequest $request)
    {
        if ($request->validated()) {
            if (auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                $request->session()->regenerate();
                return redirect()->route('admin.index');
            } else {
                return redirect()->route('admin.login')->with([
                    'error' => 'ไม่มีสิทธ์เข้าใช้งานระบบ'
                ]);
            }
        }
    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
