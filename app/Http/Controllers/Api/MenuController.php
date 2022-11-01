<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\OfferProduct;
use App\Models\Product;
use DB;
use Illuminate\Http\Request;

class MenuController extends AbstractApiController
{
    public function productDetails(Request $request, Product $product)
    {
        $related = Product::where('category_id', $product->category_id)->inRandomOrder()->limit(8)->get();

        return $this->sendResponse(compact('product', 'related'));
    }
}
