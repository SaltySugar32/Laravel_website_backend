<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Checklist;
use App\Models\Delivery;
use App\Models\DeliveryAddress;
use App\Models\Product;
use App\Models\ProductArticle;
use App\Models\Purchase;
use App\Models\Storage;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class AllModelsController extends Controller
{
    public function show($index, Request $request){
        if($request->username!=null && $request->password!=null) {
            $user = UserProfile::where('username', $request->username)->where('password', $request->password)->first();
            if ($user!=null && $user->role == '1'){
                switch ($index) {
                    case '1':
                        return response()->json(Category::all());
                    case '2':
                        return response()->json(Checklist::all());
                    case '3':
                        return response()->json(Delivery::all());
                    case '4':
                        return response()->json(DeliveryAddress::all());
                    case '5':
                        return response()->json(Product::all());
                    case '6':
                        return response()->json(ProductArticle::all());
                    case '7':
                        return response()->json(Purchase::all());
                    case '8':
                        return response()->json(Storage::all());
                    case '9':
                        return response()->json(UserProfile::all());
                        default: return response(null,400);

                }
            }
            return response(null, 403);
        }
        return response(null, 400);
    }
}
