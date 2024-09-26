<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class HomeController extends Controller
{
    //
    public function index(){
        $user=  User::all();
        $userCont=count($user);
        return view('index',compact('userCont'));
    }
}
