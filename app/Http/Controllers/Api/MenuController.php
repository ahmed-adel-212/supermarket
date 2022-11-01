<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Offer;
use App\Models\OfferProduct;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;
use App\Filters\CategoryFilter;
use App\Filters\ProductFilters;
class MenuController extends AbstractApiController
{
    public function productDetails(Request $request, int $product)
    {
        $product = Product::findOrFail($product);

        $related = Product::where('category_id', $product->category_id)->inRandomOrder()->limit(8)->get();

        return $this->sendResponse(compact('product', 'related'));
    }

    public function categories(Request $request)
    {
        // get all parent categories with sub categories
         $categories = Category::with('sub_categories')->whereNull('category_id')->get();

        $firstSubCategory = $categories->first()->sub_categories?->first();

        // load products of only first category
        $firstSubCategory->products = Product::filter(new ProductFilters(new Request($request->filter)))->where('category_id', $firstSubCategory->id)->paginate();

        return $this->sendResponse(compact('categories'));
    }

    public function categoryProducts(Request $request, int $category)
    {
        $category = Product::findOrFail($category);
        $products = Product::filter(new ProductFilters(new Request($request->filter)))->where('category_id', $category->id)->paginate();

        return $this->sendResponse(compact('products'));
    }
}
