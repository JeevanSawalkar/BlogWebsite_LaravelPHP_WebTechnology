<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class AdminController extends Controller
{
    public function post_page()
    {
        return view('admin.post_page');
    }
    public function add_post(Request $request)
    {
        $post = new Post;

        $post->title = $request->title;
        $post->description = $request->description;
        $post->image = $request->image;
        $post->save();


        return view('admin.post_page');
    }
}
