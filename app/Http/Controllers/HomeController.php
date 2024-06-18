<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Alert;

class HomeController extends Controller
{
 public function index()
 {
    if(Auth::id())
    {
        $usertype = Auth() -> user()->usertype;
        if($usertype == 'user')
        {
            $post = Post::where('post_status','=','active')->get();
             return view('home.homepage',compact('post'));
        }
        else if($usertype == 'admin')
        {
            return view('admin.adminhome');
        }
        else
        {
            return redirect()->back();
        }
    }
 }

public function homepage()
{
    $post = Post::where('post_status','=','active')->get();

    return view('home.homepage',compact('post'));
}

public function post_details($id){
    $post = Post::find($id);
    return view('home.post_details',compact('post'));
}
public function create_post(){
    return view('home.create_post');
}
public function user_post(Request $request){

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
        $post->post_status = 'pending';
        $post->user_id = $user_id;
        $post->name = $user_name;
        $post->user_type = $user_type;  
        $post->save();

        Alert::success('Congrats','Post added successfully');
    return redirect()->back();
}

public function my_post(){
    $user = Auth::user();
    $user_Id = $user->id;
    $data = Post::where('user_id','=',$user_Id)->get();

    return view('home.my_post',compact('data'));
}
public function my_post_del($id){
    $data = Post::find($id);
    $data->delete();
    return redirect()->back()->with('message','Post deleted successfully!');
}

public function my_post_edit($id){
    $data = Post::find($id);

    return view('home.my_post_edit',compact('data'));
}
public function my_post_edit_update(Request $request,$id){
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
