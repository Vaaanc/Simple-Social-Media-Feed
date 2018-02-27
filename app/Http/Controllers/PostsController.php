<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Post;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=> ['index']]);
    }

    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(10);
        return view('pages.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'newpost' => 'required|min:1|max:150'
        ]);

        $post = new Post;
        $post->content = $request->input('newpost');
        $post->user_id = auth()->user()->id;
        $message = 'There was an error :(';
        if($post->save()){
            $message = "Post succesfully created!";
        }
        
        return redirect('/')->with('message',$message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect('/')->with('message','Post Removed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        $post = Post::find($id);
        if(Auth::user() != $post->user){
            return redirect('/');
        }
        $post->delete();
        return redirect('/')->with('message','Post Removed');
    }
    
    public function updatePost(Request $request){
        $this->validate($request,[
            'content' => 'required|min:1|max:250'
        ]);
        $post = Post::find($request['postId']);
        if(Auth::user() != $post->user){
            return redirect('/');
        }
        $post->content = $request['content'];
        $post->update();
        return response()->json([
            'new-content' => $post->content,
            'message' => 'Post Updated'
        ],200);
    }
    public function del(Request $request){ 
        $post = Post::find($request['postId']);
        if(Auth::user() != $post->user){
            return redirect('/');
        }
        $post->delete();
        return response()->json(['message' => 'Post Deleted']);
    }
    
    public function post(Request $request){
        $this->validate($request,[
            'newpost' => 'required|min:1|max:250',
        ],[
            'newpost.required' => 'Post is required.',
            'newpost.min' => 'Minimum character is 1',
            'newpost.max' => 'Maximum characters is 250'
        ]);

        $post = new Post;
        $post->content = $request->input('newpost');
        $post->user_id = auth()->user()->id;
        if($post->save()){
            return response()->json([
                'message' => 'Post Created',
                'new-post' => $request->input('newpost')
            ]);
        }
    }
}
