<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Cart;


class CartService{

    public static function getItemsInCart($items){
        $products = [];

        
        foreach($items as $item){
            $p = Product::findOrFail($item->product_id);
            $owner = $p->shop->owner->select('name', 'email')->first()->toArray(); //toArray配列に変換するメソッド
            $values = array_values($owner);
            $keys = ['ownerName','email'];
            $ownerInfo = array_combine($keys, $values);//オーナー情報のキー変更
            
            $product = Product::where('id', $item->product_id) //商品情報の配列
            ->select('id','name','price')->get()->toArray();

            $quantity = Cart::where('product_id', $item->product_id) //在庫数の配列
            ->select('quantity')->get()->toArray();
            

            $result = array_merge($product[0], $ownerInfo, $quantity[0]);//配列の結合

            array_push($products, $result);//配列に追加
            // print_r($products);
        }
        
        return $products;
    }
}