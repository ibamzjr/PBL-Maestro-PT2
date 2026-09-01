<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::orderBy('name')->get();

        return view('home', compact('products', 'categories'));
    }

    public function allCategory()
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::orderBy('name')->get();

        return view('user.categories', compact('products', 'categories'));
    }

    public function show(int $id)
    {
        $product = Product::with('category')->findOrFail($id);
        $products = Product::with('category')
            ->whereKeyNot($product->id)
            ->latest()
            ->limit(6)
            ->get();

        return view('product', compact('product', 'products'));
    }
}
