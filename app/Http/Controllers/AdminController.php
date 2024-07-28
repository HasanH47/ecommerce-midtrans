<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $productCount = Product::count();
        return view('admin.index', compact('productCount'));
    }
}
