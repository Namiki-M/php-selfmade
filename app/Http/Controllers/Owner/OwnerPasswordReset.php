<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Owner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OwnerPasswordReset extends Controller
{
    public function index(){

        return view ('owner.password.password_reset');
    }

    public function confirmOwner(Request $request){
        $owner = Owner::where('name', $request->name)
        ->where('email', $request->email)->first();

        if(isset($owner)){
            $request->validate([
                'password' => 'required|string|confirmed|min:8',
            ]);

            $owner->password = Hash::make($request->password);
            $owner->save();
            
            // return view('owner.password.password_reset_edit', compact('owner'));
            return redirect()->route('owner.login');
        }else{
            $message = '情報のユーザーがいません';
            return view('owner.password.password_reset', compact('message'));
        }
    }
}
