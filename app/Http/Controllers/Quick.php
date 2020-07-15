<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Quick extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return $request;
    }

    public function get(Request $request)
    {
        return 'default (invoke) action is also GET) What do you want from me?)';
    }
}
