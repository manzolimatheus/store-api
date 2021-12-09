<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function get(){

        $users = User::all()->count();
        $products = Product::all()->count();
        $orders = Order::all()->count();

        $arr = [
            'users' => $users,
            'products' => $products,
            'orders' => $orders
        ];

        return response()->json($arr);
    }
}
