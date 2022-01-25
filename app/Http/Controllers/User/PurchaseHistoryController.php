<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseHistory;

class PurchaseHistoryController extends Controller
{
    //
    public function index(){
        $user = Auth::id();
        $users = User::findOrFail(Auth::id());
        $ab = $users->products;
        $BoughtHistories = PurchaseHistory::where('user_id', $user)->get();


        // ショップIDの取得
        $product_ids = [];
        $quantities = [];
        foreach($BoughtHistories as $BoughtHistory){
            $products = $BoughtHistory->product_id;
            $a = $BoughtHistory->user_id;
            $quantity = $BoughtHistory->quantity;
        

            array_push($product_ids, $products);
            array_push($quantities, $quantity);
        }
       

        // dd($BoughtHistories);
        // 取得したショップIDから商品情報取得
        $items = [];
        foreach($product_ids as $product_id){
        $item = Product::where('id', $product_id)->get();

        array_push($items, $item);
        }

        

        


       

        return view('user.purchase_history',
        compact('BoughtHistories','items','quantities'));



        
    }
}
