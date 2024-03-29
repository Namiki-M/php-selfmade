<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use InterventionImage;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;

class ShopController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function ($request, $next) {
            // dd($request->route()->parameter('shop'));//文字列
            // dd(Auth::id());//数列


            $id = $request->route()->parameter('shop'); //shopのid取得
            if(!is_null($id)){ // null判定
                $shopsOwnerId = Shop::findOrFail($id)->owner->id;
                $shopId = (int)$shopsOwnerId; // キャスト 文字列→数値に型変換
                $ownerId = Auth::id();
                if($shopId !== $ownerId){ // 同じでなかったら
                    abort(404); // 404画面表示
                }
            }
         

            return $next($request);
        });

    }

    public function index()
    {
        // phpinfo();
        // $owner_id = Auth::id();
        $shops = Shop::where('owner_id', Auth::id())->get();// Auth::id=元は$owner_id

        return view('owner.shops.index',
        compact('shops'));
    }

    public function edit($id)
    {
        $shop = Shop::findOrFail($id);

        return view('owner.shops.edit', compact('shop'));
        // dd(Shop::findOrFail($id));
    }

    public function update(UploadImageRequest $request, $id)//元　UploadImageRequest→Request
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'information' => 'required|string|max:1000',
            'is_selling' => 'required',
        ]);
        $imageFile = $request->image;//１次保存
        // echo $imageFile;
        // echo '<br>';
        if(!is_null($imageFile) && $imageFile->isValid() ){
            // // Storage::putFile('public/shops', $imageFile); //リサイズなし
            // $fileName = uniqid(rand(), '_');
            // // echo $fileName;
            // // echo '<br>';
            // $extension = $imageFile->extension();
            // // echo $extension;
            // // echo '<br>';
            // $fileNameToStore = $fileName.'.'.$extension;
            // // echo $fileNameToStore;
            // // echo '<br>';
            // $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();
            // // dd($imageFile, $resizedImage);

            // Storage::put('public/shops/' . $fileNameToStore, $resizedImage);
            $fileNameToStore = ImageService::upload($imageFile, 'shops');
        }

        $shop = Shop::findOrFail($id);
        $shop->name = $request->name;
        $shop->information = $request->information;
        $shop->is_selling = $request->is_selling;
        if(!is_null($imageFile) && $imageFile->isValid()){
            $shop->filename = $fileNameToStore;
        }

        $shop->save();

        return redirect()
        ->route('owner.shops.index')
        ->with(['message' => '店舗情報を更新しました。',
        'status' => 'info']);
        
    }
}
