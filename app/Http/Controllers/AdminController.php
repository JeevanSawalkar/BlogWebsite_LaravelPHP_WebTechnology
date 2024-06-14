<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function post_page()
    {
        return view('admin.post_page');
    }
    public function add_post(Request $request)
    {
        $user=Auth()->user();

        $user_id = $user->id;
        $user_name = $user->name;
        $user_type = $user->usertype;

        $post = new Post;

        $post->title = $request->title;
        $post->description = $request->description;
        //image
        $image=$request->image;
        if($image)
        {
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('postImage',$image_name);
            $post->image = $image_name;
        }

        //,,,
        $post->post_status = 'active';
        $post->user_id = $user_id;
        $post->name = $user_name;
        $post->user_type = $user_type;
        $post->save();


        // return view('admin.post_page');
        return redirect()->back()->with('message','Post added successfully');
    }
    public function show_post()
    {
        $post = Post::all();
        return view ('admin.show_post', compact('post'));
    }
    public function delete_post($id)
    {
        $post = Post::find($id);
        $post->delete();

        return redirect()->back()->with('message','Post deleted successfully');
    }

    public function edit_page($id){
        $post = Post::find($id);
        return view('admin.edit_page',compact('post'));
    }
    public function update_post(Request $request,$id){
        $data = Post::find($id);
        $data->title=$request->title;
        $data->description=$request->description;

        $image=$request->image;
        if($image)
        {
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('postImage',$image_name);
            $data->image = $image_name;
        }
        $data->save();
        return redirect()->back()->with('message','Updated successfully!');
        
    }


}
