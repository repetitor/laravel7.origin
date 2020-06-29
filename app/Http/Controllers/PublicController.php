<?php

namespace App\Http\Controllers;

use App\models\Post;
use App\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function test()
    {
        // one to one
//        $query = User::find(1);
//        if ($query) {
//            $test = $query->phone;
//        }

        // one to many
        $query = Post::find(1);
        if ($query) {
            $comments = $query->comments;
//            foreach ($comments as $comment) {
//                //
//            }
            $test = $comments;
        }

        return $test ?? 'default test answer';
    }
}
