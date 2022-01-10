<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComponentTestController;
use App\Http\Controllers\LifeCycleTestController;
use App\Http\Controllers\User\ItemController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\ChatHomeController;
use App\Http\Controllers\User\ChatController;
use App\Http\Controllers\User\PurchaseHistoryController;
use App\Events\ChatMessageReceived;

 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('user.welcome');
});

// Route::middleware('guest')->group(function(){
//     Route::get('index', [ItemController::class, 'index'])->name('user.index');

// });

//非登録ユーザーのルート設定
// Route::get('/', [ItemController::class, 'index'])
// ->middleware('guest')->name('items.index');



// Route::middleware('auth:users')->group(function(){
//         Route::get('chat', [ChatHomeController::class, 'index'])->name('chat_user_select.index');
//         Route::get('contact/{user}', [ChatController::class, 'index'])->name('chat.contact');
//         Route::post('/chat/send' , [ChatController::class, 'store'])->name('chat.send');

// });


//イベントのルート設定
// Route::get('/tasks', function () {
//     event(new ChatMessageReceived);
// });


//チャット練習用
// Route::get('post', [ChatController::class], 'index');
// Route::get('messages', [ChatController::class],'fetchMessages');
// Route::post('messages', [ChatController::class], 'sendMessage');
//ここまで

Route::middleware('auth:users')->group(function(){
    Route::get('/', [ItemController::class, 'index'])->name('items.index');
    Route::get('show/{item}',[ItemController::class, 'show'])->name('items.show');

});

Route::middleware('auth:users')->group(function(){
    Route::get('purchase_history', [PurchaseHistoryController::class, 'index'])->name('purchase_history.index');
});

Route::prefix('cart')->
    middleware('auth:users')->group(function(){
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('add', [CartController::class, 'add'])->name('cart.add');
        Route::post('delete/{item}', [CartController::class, 'delete'])->name('cart.delete');
        Route::get('checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::get('success', [CartController::class, 'success'])->name('cart.success');
        Route::get('cancel', [CartController::class, 'cancel'])->name('cart.cancel');
        Route::get('address_confirm', [CartController::class, 'addressIndex'])->name('cart.address_confirm');
        Route::post('address_update', [CartController::class, 'addressUpdate'])->name('cart.address_update');
});

// Route::get('/dashboard', function () {
//     return view('user.dashboard');
// })->middleware(['auth:users'])->name('dashboard');

Route::get('/component-test1', [ComponentTestController::class, 'showComponent1']);
Route::get('/component-test2', [ComponentTestController::class, 'showComponent2']);
Route::get('/servicecontainertest', [LifeCycleTestController::class, 'showServiceContainerTest']);
Route::get('/serviceprovidertest', [LifeCycleTestController::class, 'showServiceProviderTest']);

require __DIR__.'/auth.php';
