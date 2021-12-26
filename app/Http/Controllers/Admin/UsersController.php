<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; //Eloquent エロクアント
use Illuminate\Support\Facades\DB; //QueryBuilder クエリビルダー
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Throwable;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:admin');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('id','name','email','created_at')
        ->paginate(3);

        return view('admin.users.index',
        compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            /**
     * 都道府県リスト
     *
     * @var array
     */
    
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

        return view('admin.users.create',
        compact('prefs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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


        try{
            DB::transaction(function () use($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'postal_code' => $request->postal_code,
                    'pref_id' => $request->pref_id,
                    'city' => $request->city,
                    'town' => $request->town,
                    'building' => $request->building,
                    'phone_number' => $request->phone_number,
                ]);

            }, 2);

        }catch(Throwable $e){
            Log::error($e);
            throw $e;
        }

        return redirect()
        ->route('admin.users.index')
        ->with(['message' => 'ユーザー登録を実施しました。',
        'status' => 'info']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
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
        // dd($owner);
        return view('admin.users.edit', compact('user','prefs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if($request->email == $user->email ){
            $request->validate([
                'name' => 'required|string|max:255',
                'password' => 'required|string|confirmed|min:8',
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
                'password' => 'required|string|confirmed|min:8',
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
        $user->password = Hash::make($request->password);
        $user->postal_code = $request->postal_code;  
        $user->pref_id = $request->pref_id;
        $user->city = $request->city;
        $user->town = $request->town;  
        $user->building = $request->building;  
        $user->phone_number = $request->phone_number;
        
        $user->save();

        return redirect()
        ->route('admin.users.index')
        ->with(['message' => 'ユーザー情報を更新しました。',
        'status' => 'info']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete(); //ソフトデリート

        return redirect()
        ->route('admin.users.index')
        ->with(['message' => 'ユーザー情報を削除しました。', 
        'status' => 'alert' ]);
    }
}
