<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserPasswordReset extends Controller
{
    public function index(){

        return view ('user.password.password_reset');
    }

    public function confirmUser(Request $request){
        $user = User::where('name', $request->name)
        ->where('email', $request->email)
        ->where('phone_number', $request->phone_number)->first();

        if(isset($user)){
            $request->validate([
                'password' => 'required|string|confirmed|min:8',
            ]);

            $user->password = Hash::make($request->password);
            $user->save();
            
            // return view('user.password.password_reset_edit', compact('user'));
            return redirect()->route('user.login');
        }else{
            $message = '情報のユーザーがいません';
            return view('user.password.password_reset', compact('message'));
        }
    }

}
