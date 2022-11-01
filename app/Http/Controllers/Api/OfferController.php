<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Offer;
use App\Models\OfferProduct;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;

class OfferController extends AbstractApiController
{
    public function categories(Request $request)
    {
        // get all parent categories with sub categories
        $categories = Category::with('sub_categories')->whereNull('category_id')->get();

        if ($categories->first()?->sub_categories?->first()) {
            // load products of only first category
            $categories->first()->sub_categories->first()->products = Product::select(DB::raw('products.*'))
                ->join(DB::raw('offer_product op'), 'op.product_id', 'products.id')
                ->join(DB::raw('offers o'), 'o.id', 'op.offer_id')
                ->where(DB::raw('DATE(o.date_from)'), '<=', now())
                ->where(DB::raw('DATE(o.date_to)'), '>=', now())
                ->paginate();
        }

        return $this->sendResponse(compact('categories'));
    }

    public function categoryProducts(Request $request, int $category)
    {
        $category = Product::findOrFail($category);

        $products = Product::select(DB::raw('products.*'))
            ->join(DB::raw('offer_product op'), 'op.product_id', 'products.id')
            ->join(DB::raw('offers o'), 'o.id', 'op.offer_id')
            ->where(DB::raw('DATE(o.date_from)'), '<=', now())
            ->where(DB::raw('DATE(o.date_to)'), '>=', now())
            ->paginate();

        return $this->sendResponse(compact('products'));
    }
}
