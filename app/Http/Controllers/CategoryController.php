<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $products = Product::with(['galleries'])->paginate(12);
        $categories = Category::all();

        return view('pages.category', compact('products', 'categories'));
    }

    public function detail(Request $request, $slug)
    {
        $categories = Category::all();
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::with(['galleries'])->where('categories_id', $category->id)->paginate(12);

        return view('pages.category', compact('products', 'categories'));
    }
}
