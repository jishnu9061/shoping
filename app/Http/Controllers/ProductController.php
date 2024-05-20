<?php

/**
 * Created By: JISHNU T K
 * Date: 2024/05/20
 * Time: 20:20:34
 * Description: ProductController.php
 */

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

use App\Http\Requests\ProductStoreRequest;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Create Product
     *
     * @return [type]
     */
    public function index()
    {
        $categories = Category::pluck('name', 'id');
        return view('pages.create', compact('categories'));
    }

    /**
     * Store Product
     *
     * @param ProductStoreRequest $request
     *
     * @return [type]
     */
    public function store(ProductStoreRequest $request)
    {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'code' => $request->code,
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => $imagePath ?? null,
            'price' => $request->price,
        ]);
        return redirect()->route('products.list')->with('success', 'Product created successfully.');
    }

    /**
     * Show Product List
     *
     * @return [type]
     */
    public function productList()
    {
        $products = Product::select('id', 'code', 'category_id', 'description', 'image', 'price')->get();
        $categories = Category::pluck('name', 'id');
        return view('pages.list', compact('products', 'categories'));
    }

    /**
     * Filter Product
     *
     * @param Request $request
     *
     * @return [type]
     */
    public function filterProducts(Request $request)
    {
        $categoryId = $request->input('category_id');
        $products = ($categoryId) ? Product::where('category_id', $categoryId)->get() : Product::all();
        $categories = Category::pluck('name', 'id');
        $html = view('partials.product-list', compact('products'))->render();
        return response()->json(['success' => true, 'data' => $html]);
    }
}
