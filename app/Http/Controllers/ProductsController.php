<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductArticle;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index(Request $request){
        if ($request->category_id!=null){
            if(Product::where('category_id', $request->category_id)->first()!=null)
            return response()->json(ProductArticle::whereIn('product_id',
                Product::where('category_id', $request->category_id)->get('id')
            )->get());
            return response(null,404);
        }
        $productarticles=ProductArticle::all();
        $data=[];
        foreach ($productarticles as $productarticle) {
            $product = Product::where('id', $productarticle->product_id)->first();
            array_push($data, [
                'id'=>$productarticle->id,
                'title'=>$productarticle->title,
                'description'=>$productarticle->description,
                'short_description'=>$productarticle->short_description,
                'picture_link'=>$productarticle->picture_link,
                'price'=>$product->price,
                'category_id'=>$product->category_id]);
        }
        return response()->json($data);
    }

    public function show($index)
    {
        $productarticle = ProductArticle::where('id', $index)->first();
        if ($productarticle != null) {
            $product = Product::where('id', $productarticle->product_id)->first();
            $data = [];
            array_push($data, [
                'title' => $productarticle->title,
                'description' => $productarticle->description,
                'short_description' => $productarticle->short_description,
                'picture_link' => $productarticle->picture_link,
                'price' => $product->price,
                'category_id' => $product->category_id]);
            return response()->json($data);
        }
        return response(null,404);
    }
}
