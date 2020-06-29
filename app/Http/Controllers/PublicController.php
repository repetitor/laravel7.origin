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
//            $response = $query->phone;
//        }

        // one to many
//        $query = Post::find(1);
//        if ($query) {
//            $comments = $query->comments;
//////            foreach ($comments as $comment) {
//////                //
//////            }
////            $response = $comments;
//
////            $comment = $comments->where('name', 'comment*')->first();
//            $comment = $comments->where('id', '8')->first();
////            $response = $comment;
//            $response = $comment->post->name;
//        }

        $user = User::find(1);

//        foreach ($user->roles as $role) {
////            echo $role->pivot->created_at;
//            $response = $role->pivot;
//        }

        $response = $user->roles;

        return $response ?? 'default test answer';
    }
}
