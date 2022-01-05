<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Owner;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{

    public function __construct()
    {
        //チャット練習用
  
        $this->middleware('auth');
        //ここまで
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $receive)
    {
        // // チャットの画面
        // $loginId = Auth::id();
 
        // $param = [
        //   'send' => $loginId,
        //   'receive' => $receive,
        // ];
 
        // // 送信 / 受信のメッセージを取得する
        // $query = Message::where('send' , $loginId)->where('receive' , $receive);;
        // $query->orWhere(function($query) use($loginId , $receive){
        //     $query->where('send' , $receive);
        //     $query->where('receive' , $loginId);
 
        // });
 
        // $messages = $query->get();
 
        // return view('user.chat' , compact('param' , 'messages'));


        // //チャット練習用始まり
        // return view('post');

        // //ここまで


    }

    //チャット練習用始まり
    // public function fetchMessages()
    // {
    //     return Message::with('user')->get();
    // }

    // public function sendMessage(Request $request)
    // {
    //     $user = Auth::user();
 
    //     $message = $user->messages()->create([
    //         'message' => $request->input('message')
    //     ]);
 
    //     event(new MessageSent($user, $message));
 
    //     return ['status' => 'Message Sent!'];
    // }
    //練習ここまで

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // リクエストパラメータ取得
        $insertParam = [
            'send' => $request->input('send'),
            'receive' => $request->input('receive'),
            'message' => $request->input('message'),
        ];
 
 
        // メッセージデータ保存
        try{
            Message::insert($insertParam);
        }catch (\Exception $e){
            return false;
 
        }
 
 
        // イベント発火
        event(new ChatMessageReceived($request->all()));
 
        // メール送信
        $mailSendUser = User::where('id' , $request->input('receive'))->first();
        $to = $mailSendUser->email;
        Mail::to($to)->send(new SampleNotification());
 
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::id();
 
        // オーナーを取得する
        $owners = Owner::select('id','name','email','created_at')->get();
        $shops = Shop::select('id','owner_id','name')->get();
        
        // チャットユーザ選択画面を表示
        return view('user.chat_user_select' , compact('owners','shops'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
