<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\Delivery;
use App\Models\DeliveryAddress;
use App\Models\Product;
use App\Models\ProductArticle;
use App\Models\Purchase;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Table;

class CartController extends Controller
{
    public function show(Request $request){
        if($request->username!=null && $request->password!=null) {
            $user = UserProfile::where('username', $request->username)->where('password', $request->password)->first();
            if($user!=null) {
                $purchase = Purchase::where('user_profile_id', $user->id)->first();
                $checklists = Checklist::where('top_id', $purchase->checklist_top_id)->get();
                if ($checklists != null) {
                    $data = [];
                    $inc=1;
                    foreach ($checklists as $check) {
                        $productarticle = ProductArticle::where('id', $check->product_article_id)->first();
                        $product = Product::where('id', $productarticle->product_id)->first();
                        $price = ($product->price) * ($check->purchase_amount);
                        array_push($data, [
                            'id'=>$inc++,
                            'title' => $productarticle->title,
                            'picture_link' => $productarticle->picture_link,
                            'purchase_amount' => $check->purchase_amount,
                            'price' => $price]);
                    }
                    return $data!=[]? response()->json($data):response()->json(null);
                }
                return response()->json(null);
            }
            return response(null, 401);
        }
        return response(null, 400);
    }

    public function add(Request $request){
        if($request->username!=null && $request->password!=null && $request->product_article_id!=null && $request->purchase_amount!=null) {
            $user = UserProfile::where('username', $request->username)->where('password', $request->password)->first();
            if ($user != null) {
                $purchase = Purchase::where('user_profile_id', $user->id)->first();
                $count = 0;
                if($purchase->checklist_top_id==null)
                {
                    $latest = Checklist::orderBy('top_id', 'desc')->first();
                    Purchase::where('id', $purchase->id)->update(['checklist_top_id'=>$latest->top_id+1]);
                    $purchase = Purchase::where('user_profile_id', $user->id)->first();
                }

                else {
                    $existingcheck = Checklist::where('top_id', $purchase->checklist_top_id)->where('product_article_id', $request->product_article_id)->first();
                    if($existingcheck!=null){
                        $newamount = $existingcheck->purchase_amount+$request->purchase_amount;
                        Checklist::where('top_id', $purchase->checklist_top_id)->where('product_article_id', $request->product_article_id)->update(['purchase_amount' =>$newamount]);
                        $productarticle = ProductArticle::where('id', $request->product_article_id)->first();
                        $product = Product::where('id', $productarticle->product_id)->first();
                        $price = $product->price*$existingcheck->purchase_amount;
                        Purchase::where('id', $purchase->id)->update(['total_price'=>$purchase->total_price+$price]);
                        return response()->json(true, 201);
                    }
                    $checklists = Checklist::where('top_id', $purchase->checklist_top_id)->get();

                    if ($checklists != null) {
                        foreach ($checklists as $check) {
                            $count++;
                        }
                    }
                }

                Checklist::create([
                    'top_id'=>($purchase->checklist_top_id),
                    'bot_id'=>$count+1,
                    'purchase_id'=>$purchase->id,
                    'product_article_id'=>$request->product_article_id,
                    'purchase_amount'=>$request->purchase_amount
                ]);
                $productarticle = ProductArticle::where('id', $request->product_article_id)->first();
                $product = Product::where('id', $productarticle->product_id)->first();
                $price = $product->price*$request->purchase_amount;
                Purchase::where('id', $purchase->id)->update(['total_price'=>$purchase->total_price+$price]);
                return response()->json(true, 201);
            }
            return response(null, 401);
        }
        return response(null,400);
    }

    public function clearcart(Request $request){
        if($request->username!=null && $request->password!=null) {
            $user = UserProfile::where('username', $request->username)->where('password', $request->password)->first();
            if ($user != null) {
                $purchase = Purchase::where('user_profile_id', $user->id)->first();
                if ($purchase->checklist_top_id != null){
                    Checklist::where('top_id', $purchase->checklist_top_id)->delete();
                    Purchase::where('user_profile_id', $user->id)->update([
                        'total_price' => 0,
                        'checklist_top_id' => null
                    ]);
                }
                return response()->json(true,201);
            }
            return response(null, 401);
        }
        return response(null, 400);
    }

    public function submit(Request $request){
        if($request->username!=null && $request->password!=null && $request->city!=null && $request->street!=null && $request->building!=null && $request->date_time!=null) {
            $user = UserProfile::where('username', $request->username)->where('password', $request->password)->first();
            if ($user != null) {
                $purchase = Purchase::where('user_profile_id', $user->id)->first();
                if ($purchase->checklist_top_id != null){
                    DeliveryAddress::create([
                        'city' => $request->city,
                        'street' => $request->street,
                        'building' => $request->building
                    ]);
                    $latestaddr = DeliveryAddress::orderBy('id', 'desc')->first();
                    Delivery::create([
                        'delivery_address_id' => $latestaddr->id,
                        'user_profile_id' => $user->id,
                        'delivery_date_time' => $request->date_time,
                        'delivery_status' => 0,
                        'checklist_top_id' => $purchase->checklist_top_id
                    ]);
                    Purchase::where('user_profile_id', $user->id)->update([
                        'total_price' => 0,
                        'checklist_top_id' => null
                    ]);
                    return response()->json(true, 201);
                }
            }
            return response(null, 401);
        }
        return response(null, 400);
    }
}
