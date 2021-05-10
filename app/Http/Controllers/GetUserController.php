<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class GetUserController extends Controller
{
    //Userテーブルの全レコード取得
    public function get(){
        $users = new User;
        $users_list = $users -> getUsersList();
        return $users_list; 
    }
}
