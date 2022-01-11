<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\Stock;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; //QueryBuilder クエリビルダー
use App\Services\CartService;
use App\Jobs\SendThanksMail;
use App\Jobs\SendOrderedMail;
use App\Models\PurchaseHistory;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{

    public function index(){
        // $a = User::get();
        // $q_get = DB::table('users')->select('name','id')->get();
        // print_r($q_get);
        $user = User::findOrFail(Auth::id());
        // print_r($user);
        
        $products = $user->products;
        // dd($products);
        $totalPrice = 0;

        foreach($products as $product){
   
            $totalPrice = $product->price * $product->pivot->quantity;
        }
      
        // dd($products,$totalPrice);

        return view('user.cart', 
        compact('products','totalPrice'));
    }
    //

    public function add(Request $request){
        // dd($request);
        $itemInCart = Cart::where('product_id', $request->product_id)
        ->where('user_id', Auth::id())->first();

        if($itemInCart){
            $itemInCart->quantity += $request->quantity;
            $itemInCart->save();

        }else{
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }
        return redirect()->route('user.cart.index');
    }

    public function delete($id){
        Cart::where('product_id', $id)
        ->where('user_id', Auth::id())
        ->delete();

        return redirect()->route('user.cart.index');
    }

    public function checkout(){
        
        ////stripeにデータを送るためのもの
        $user = User::findOrFail(Auth::id());
        $products = $user->products;

        $lineItems = [];
        foreach($products as $product){
            $quantity = '';
            $quantity = Stock::where('product_id', $product->id)->sum('quantity');
            if($product->pivot->quantity > $quantity){
                return redirect()->route('user.cart.index');

            }else{

                $lineItem = [
                    'name' => $product->name,
                    'description' => $product->information,
                    'amount' => $product->price, //amountが存在しない可能性あり
                    'currency' => 'jpy', //currencyが存在しない可能性あり
                    'quantity' => $product->pivot->quantity,
                ];
                array_push($lineItems, $lineItem);
            }


        }
        // dd($lineItems);
        foreach($products as $product){
            Stock::create([
                'product_id' => $product->id,
                'type' => \Constant::PRODUCT_LIST['reduce'],
                'quantity' => $product->pivot->quantity * -1,
            ]);

        }

        // dd('test');

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [$lineItems],
            'mode' => 'payment',
            'success_url' => route('user.cart.success'),
            'cancel_url' => route('user.cart.cancel'),
        ]);

        $publicKey = env('STRIPE_PUBLIC_KEY');

        return view('user.checkout',
            compact('session','publicKey'));
    }

    public function success(){
        ////
        $items = Cart::where('user_id', Auth::id())->get();
        $products = CartService::getItemsInCart($items);
        $user = User::findOrFail(Auth::id());
        // $b = Auth::id();
        // dd($b);
        $prefs = [
            1 => '北海道',
            2 => '青森県', 3 => '岩手県', 4 => '宮城県', 5 => '秋田県', 6 => '山形県', 7 => '福島県',
            8 => '茨城県', 9 => '栃木県', 10 => '群馬県', 11 => '埼玉県', 12 => '千葉県', 13 => '東京都', 14 => '神奈川県',
            15 => '新潟県', 16 => '富山県', 17 => '石川県', 18 => '福井県', 19 => '山梨県', 20 => '長野県',
            21 => '岐阜県', 22 => '静岡県', 23 => '愛知県', 24 => '三重県',
            25 => '滋賀県', 26 => '京都府', 27 => '大阪府', 28 => '兵庫県', 29 => '奈良県', 30 => '和歌山県',
            31 => '鳥取県', 32 => '島根県', 33 => '岡山県', 34 => '広島県', 35 => '山口県',
            36 => '徳島県', 37 => '香川県', 38 => '愛媛県', 39 => '高知県',
            40 => '福岡県', 41 => '佐賀県', 42 => '長崎県', 43 => '熊本県', 44 => '大分県', 45 => '宮崎県', 46 => '鹿児島県', 47 => '沖縄県',
        ];

        foreach($prefs as $key => $pref){
            if($key == $user['pref_id']){
                $place = $pref;
            }    
        }

        // foreach($products as $product){
        //     dd($product['name']);
        // }

        // dd($products);

        // dd($place);

   
        // 購入履歴及び販売履歴用のテーブル
        // $product_id = Product::where('id', $product['id']);

        foreach($products as $product){  
            $product_id = Product::findOrFail($product['id']);
       
            $price = $product['price'] * $product['quantity'];
            PurchaseHistory::create([
                'user_id' => Auth::id(),
                'product_id' => $product['id'],
                'shop_id' => $product_id['shop_id'],
                'quantity' => $product['quantity'],
                'price' => $price,
            ]);
        }


        SendThanksMail::dispatch($products,$user);

        foreach($products as $product)
        {
            SendOrderedMail::dispatch($product, $user, $place);
        }
        //
        Cart::where('user_id', Auth::id())->delete();
        return redirect()->route('user.items.index');
    }


    
    public function cancel(){
        $user = User::findOrFail(Auth::id());

        foreach($user->products as $product){
            Stock::create([
                'product_id' => $product->id,
                'type' => \Constant::PRODUCT_LIST['add'],
                'quantity' => $product->pivot->quantity,
            ]);
        }

        return redirect()->route('user.cart.index');
    }

    public function addressIndex(){
        $user = User::findOrFail(Auth::id());
        

        $prefs = [
            1 => '北海道',
            2 => '青森県', 3 => '岩手県', 4 => '宮城県', 5 => '秋田県', 6 => '山形県', 7 => '福島県',
            8 => '茨城県', 9 => '栃木県', 10 => '群馬県', 11 => '埼玉県', 12 => '千葉県', 13 => '東京都', 14 => '神奈川県',
            15 => '新潟県', 16 => '富山県', 17 => '石川県', 18 => '福井県', 19 => '山梨県', 20 => '長野県',
            21 => '岐阜県', 22 => '静岡県', 23 => '愛知県', 24 => '三重県',
            25 => '滋賀県', 26 => '京都府', 27 => '大阪府', 28 => '兵庫県', 29 => '奈良県', 30 => '和歌山県',
            31 => '鳥取県', 32 => '島根県', 33 => '岡山県', 34 => '広島県', 35 => '山口県',
            36 => '徳島県', 37 => '香川県', 38 => '愛媛県', 39 => '高知県',
            40 => '福岡県', 41 => '佐賀県', 42 => '長崎県', 43 => '熊本県', 44 => '大分県', 45 => '宮崎県', 46 => '鹿児島県', 47 => '沖縄県',
        ];


        return view('user.address_confirm',
        compact('user','prefs'));
    }

    public function addressUpdate(Request $request){
        $user = User::findOrFail(Auth::id());
        if($request->email == $user->email ){
            $request->validate([
                'name' => 'required|string|max:255',
                'postal_code' => ['required', 'regex:/^[0-9]{3}-[0-9]{4}$/'],
                'pref_id' => ['required'],
                'city' => ['required', 'max:50',],
                'town' => ['required', 'max:50'],
                'building' => ['max:50'],
                'phone_number' => ['required', 'regex:/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{4}$/'],
            ]);
        }else{
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'postal_code' => ['required', 'regex:/^[0-9]{3}-[0-9]{4}$/'],
                'pref_id' => ['required'],
                'city' => ['required', 'max:50',],
                'town' => ['required', 'max:50'],
                'building' => ['max:50'],
                'phone_number' => ['required', 'regex:/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{4}$/'],
            ]);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->postal_code = $request->postal_code;
        $user->pref_id = $request->pref_id;
        $user->city = $request->city;
        $user->town = $request->town;
        $user->building = $request->building;
        $user->phone_number = $request->phone_number;
        $user->save();

        $prefs = [
            1 => '北海道',
            2 => '青森県', 3 => '岩手県', 4 => '宮城県', 5 => '秋田県', 6 => '山形県', 7 => '福島県',
            8 => '茨城県', 9 => '栃木県', 10 => '群馬県', 11 => '埼玉県', 12 => '千葉県', 13 => '東京都', 14 => '神奈川県',
            15 => '新潟県', 16 => '富山県', 17 => '石川県', 18 => '福井県', 19 => '山梨県', 20 => '長野県',
            21 => '岐阜県', 22 => '静岡県', 23 => '愛知県', 24 => '三重県',
            25 => '滋賀県', 26 => '京都府', 27 => '大阪府', 28 => '兵庫県', 29 => '奈良県', 30 => '和歌山県',
            31 => '鳥取県', 32 => '島根県', 33 => '岡山県', 34 => '広島県', 35 => '山口県',
            36 => '徳島県', 37 => '香川県', 38 => '愛媛県', 39 => '高知県',
            40 => '福岡県', 41 => '佐賀県', 42 => '長崎県', 43 => '熊本県', 44 => '大分県', 45 => '宮崎県', 46 => '鹿児島県', 47 => '沖縄県',
        ];

        $message = "ユーザー情報を更新しました。";

        return view('user.address_confirm',
        compact('user','prefs','message'));

        
    }

    public function confirm(){
        $user = User::findOrFail(Auth::id());
        // print_r($user);
        
        $products = $user->products;
        // dd($products);
        $totalPrice = 0;

        foreach($products as $product){
   
            $totalPrice = $product->price * $product->pivot->quantity;
        }
      
        $prefs = [
            1 => '北海道',
            2 => '青森県', 3 => '岩手県', 4 => '宮城県', 5 => '秋田県', 6 => '山形県', 7 => '福島県',
            8 => '茨城県', 9 => '栃木県', 10 => '群馬県', 11 => '埼玉県', 12 => '千葉県', 13 => '東京都', 14 => '神奈川県',
            15 => '新潟県', 16 => '富山県', 17 => '石川県', 18 => '福井県', 19 => '山梨県', 20 => '長野県',
            21 => '岐阜県', 22 => '静岡県', 23 => '愛知県', 24 => '三重県',
            25 => '滋賀県', 26 => '京都府', 27 => '大阪府', 28 => '兵庫県', 29 => '奈良県', 30 => '和歌山県',
            31 => '鳥取県', 32 => '島根県', 33 => '岡山県', 34 => '広島県', 35 => '山口県',
            36 => '徳島県', 37 => '香川県', 38 => '愛媛県', 39 => '高知県',
            40 => '福岡県', 41 => '佐賀県', 42 => '長崎県', 43 => '熊本県', 44 => '大分県', 45 => '宮崎県', 46 => '鹿児島県', 47 => '沖縄県',
        ];

        return view('user.before_buy', 
        compact('products','totalPrice','user','prefs'));

    }
}
