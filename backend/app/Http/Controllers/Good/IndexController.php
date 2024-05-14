<?php

namespace App\Http\Controllers\Good;

use App\Http\Controllers\Controller;
use App\Http\Resources\Good\GoodResource;
use Illuminate\Http\Request;
use App\Models\Good;
use App\Models\Price;
use App\Models\Region;

class IndexController extends Controller
{
    public function get($good_id, $region_id){
        $product = Good::find($good_id);
        if (! $product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        $productName = $product->name;
        $price = Price::where(['good_id' => $good_id, 'region_id'=>$region_id])->first();
        if (! $price) {
            return response()->json(['error' => 'Price not found for this region'], 404);
        }
        $regionPrice = $price->value;

        $regionName = Region::find($region_id);

        // Return response with product name and price
        return response()->json([
            'product_name' => $productName,
            'region_price' => $regionPrice,
            'region_name' =>$regionName->name,
            'product_quantity' => $product->quantity,

        ]);

    }
    public function all(){
        $goods = Good::all();
        return GoodResource::collection($goods);
    }
    public function add(Request $request){
        return dd($request);
    }
    public function delete(Request $request){}

}