<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\Shop;
use App\Models\Product;
use App\Models\PurchaseHistory;
use Illuminate\Support\Facades\Auth;

class SoldController extends Controller
{
    public function index(){
        // $owner = Owner::findOrFail(Auth::id());
        // $Shop = $owner->shop->name;
        // print_r($Shop);
        // echo 'aaa';



        return view('owner.sold.index');
    }
}
