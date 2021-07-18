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

class DeliveryController extends Controller
{
    public function show(Request $request)
    {
        if ($request->username != null && $request->password != null) {
            $user = UserProfile::where('username', $request->username)->where('password', $request->password)->first();
            if ($user != null) {
                $deliveries = Delivery::where('user_profile_id', $user->id)->get();
                //$checklists = Checklist::where('top_id', $purchase->checklist_top_id)->get();
                if ($deliveries != null)
                    $data = [];
                $inc = 1;
                foreach ($deliveries as $delivery) {

                    $deliveryaddress = DeliveryAddress::where('id', $delivery->delivery_address_id)->first();
                    array_push($data, [
                        'id' => $inc++,
                        'delivery_date_time' => $delivery->delivery_date_time,
                        'delivery_status' => $delivery->delivery_status,
                        'city' => $deliveryaddress->city,
                        'street' => $deliveryaddress->street,
                        'building' => $deliveryaddress->building]);
                }
                return $data != [] ? response()->json($data) : response()->json(null);
            }
            return response(null, 401);
        }
        return response(null, 400);
    }

    public function detailedshow(Request $request)
    {
        if ($request->username != null && $request->password != null) {
            $user = UserProfile::where('username', $request->username)->where('password', $request->password)->first();
            if ($user != null) {
                $deliveries = Delivery::where('user_profile_id', $user->id)->get();
                //$checklists = Checklist::where('top_id', $purchase->checklist_top_id)->get();
                $data = [];
                $inc = 1;
                foreach ($deliveries as $delivery) {
                    $checklists = Checklist::where('top_id', $delivery->checklist_top_id)->get();
                    foreach ($checklists as $check) {
                        $deliveryaddress = DeliveryAddress::where('id', $delivery->delivery_address_id)->first();
                        $productarticle = ProductArticle::where('id', $check->product_article_id)->first();
                        $product = Product::where('id', $productarticle->product_id)->first();
                        $price = ($product->price) * ($check->purchase_amount);
                        array_push($data, [
                            'id' => $inc++,
                            'delivery_date_time' => $delivery->delivery_date_time,
                            'delivery_status' => $delivery->delivery_status,
                            'city' => $deliveryaddress->city,
                            'street' => $deliveryaddress->street,
                            'building' => $deliveryaddress->building,
                            'title' => $productarticle->title,
                            'picture_link' => $productarticle->picture_link,
                            'purchase_amount' => $check->purchase_amount,
                            'price' => $price
                        ]);
                    }
                }
                return $data != [] ? response()->json($data) : response()->json(null);
            }
            return response(null, 401);
        }
        return response(null, 400);
    }
}
