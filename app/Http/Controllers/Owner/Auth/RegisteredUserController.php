<?php

namespace App\Http\Controllers\Owner\Auth;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\Log;
use App\Models\Shop;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('owner.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:owners'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
//登録の際に、SHOP作成する、考える

    try{



    
        Auth::login($user = Owner::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]));

        Shop::create([
            'owner_id' => $user->id,
            'name' => '店名を入力してください',
            'information' => '',
            'filename' => '',
            'is_selling' => true
        ]);

    }catch(Throwable $e){
        Log::error($e);
        throw $e;
    }




        event(new Registered($user));

        // try{
        //     DB::transaction(function () use($request) {
        //         $owner = Owner::create([
        //             'name' => $request->name,
        //             'email' => $request->email,
        //             'password' => Hash::make($request->password),
        //         ]);

        //         Shop::create([
        //             'owner_id' => $owner->id,
        //             'name' => '店名を入力してください',
        //             'information' => '',
        //             'filename' => '',
        //             'is_selling' => true
        //         ]);
        //     }, 2);
        // }catch(Throwable $e){
        //     Log::error($e);
        //     throw $e;
        // }


        Auth::login($user);

        return redirect(RouteServiceProvider::OWNER_HOME);
    }
}
