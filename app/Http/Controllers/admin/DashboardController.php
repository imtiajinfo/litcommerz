<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\StockLedger;
use App\Models\PurchaseMaster;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $data['customers'] = User::count();
        $data['orders'] = Order::count();
        $data['pending_orders'] = Order::where('track_status', 0)->count();
        $data['completed_orders'] = Order::where('track_status', 5)->count();
        $data['total_sale'] = Order::sum('total_amount');
        $data['total_pending'] = Order::where('track_status', 0)->sum('total_amount');
        $data['total_stock'] = Product::where('available_stock', '>', 0)->sum(DB::raw('sell_price * available_stock'));
        $data['total_product'] = Product::count();

        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $months->push(now()->subMonths($i)->format('M Y')); // e.g., Aug 2025
        }

        // Sales per month
        $sales = [];
        foreach ($months as $month) {
            $sales[] = Order::whereYear('created_at', date('Y', strtotime($month)))
                            ->whereMonth('created_at', date('m', strtotime($month)))
                            ->sum('total_amount');
        }

        // Prepare chart data
        $chart_data = [['Month', 'Total Sales']];
        foreach ($months as $index => $month) {
            $chart_data[] = [$month, $sales[$index]];
        }

        $data['chart_data'] = $chart_data; 


        return view('admin.dashboard', $data);
    }
}
