<?php

namespace App\Http\Controllers\Website\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $ordersCount = Order::where('status', 'pending')->count();

        // branches
        $productsCount = Product::count();

        // categories
        $categoriesCount = Category::count();

        // customers
        $customersCount = User::whereType('user')->count();

        return view('admin.dashboard', compact('ordersCount', 'productsCount', 'categoriesCount', 'customersCount'));
    }
}
