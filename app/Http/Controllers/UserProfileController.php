<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function find(Request $request){
        if($request->username!=null && $request->password!=null) {
            $user=UserProfile::where('username', $request->username)->where('password', $request->password)->first();
            return $user!=null? response()->json(true):response()->json(false);
        }
        return response()->json(false,400);
    }

    public function findadmin(Request $request){
        if($request->username!=null && $request->password!=null) {
            $user=UserProfile::where('username', $request->username)->where('password', $request->password)->first();
            return $user->role=='1'? response()->json(true):response()->json(false);
        }
        return response()->json(false,400);
    }

    public function add(Request $request){
        if($request->username!=null && $request->password!=null) {
            $user = UserProfile::where('username', $request->username)->where('password', $request->password)->first();
            if ($user == null) {
                UserProfile::create([
                    'username' => $request->username,
                    'password' => $request->password,
                    'role' => 0
                ]);
                $user=UserProfile::where('username', $request->username)->where('password', $request->password)->first();
                Purchase::create([
                    'user_profile_id'=>$user->id,
                    'total_price'=>0,
                    'checklist_top_id'=>null
                ]);
                return response()->json(true, 201);
            }
            return response(null, 409);
        }
        return response(null, 400);
    }
}
