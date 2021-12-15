<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComponentTestController extends Controller
{
    //
    public function showComponent1(){
        $message = "テストメッセージ";
        $message1 = "aaaaa";
        return view('tests.component-test1', compact('message1', 'message'));
    }

    public function showComponent2(){
        return view('tests.component-test2');
    }
}
