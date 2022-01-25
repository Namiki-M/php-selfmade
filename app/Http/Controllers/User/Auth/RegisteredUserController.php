<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
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
        return view('user.auth.register',
        compact('prefs'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'postal_code' => ['required', 'regex:/^[0-9]{3}-[0-9]{4}$/'],
            'pref_id' => ['required'],
            'city' => ['required', 'max:50',],
            'town' => ['required', 'max:50'],
            'building' => ['max:50'],
            'phone_number' => ['required', 'regex:/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{4}$/'],
        ]);

        Auth::login($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'postal_code' => $request->postal_code,
            'pref_id' => $request->pref_id,
            'city' => $request->city,
            'town' => $request->town,
            'building' => $request->building,
            'phone_number' => $request->phone_number,
        ]));

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
