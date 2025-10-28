<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // ambil produk (bisa paginasi nanti)
        $products = Product::latest()->take(12)->get();

        return view('welcome', compact('products'));
    }
}