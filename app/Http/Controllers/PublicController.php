<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function test()
    {
        $test = User::find(1)->phone;

        return $test;
    }
}
