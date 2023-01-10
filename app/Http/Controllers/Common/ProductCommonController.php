<?php

namespace App\Http\Controllers\Common;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductCommonController
{
    public function index(Request $request)
    {

        $query = Product::query();

        if($search = $request->input('search')) {
            $query->whereRaw("title LIKE '%{$search}%'")
                ->orWhereRaw("description LIKE '%{$search}%'");
        }

        return ProductResource::collection($query->get());
    }
}
