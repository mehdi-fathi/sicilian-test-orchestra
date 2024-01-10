<?php

namespace Tests\Tests\Controller;


use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    // Display a listing of the resource.
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    // Show the form for creating a new resource.
    public function create()
    {
        return view('posts.create');
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        Post::create($validatedData);

        return redirect('/posts')->with('success', 'Post created successfully.');
    }

    // Display the specified resource.
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    // Show the form for editing the specified resource.
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    // Update the specified resource in storage.
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $post->update($validatedData);

        return redirect('/posts')->with('success', 'Post updated successfully.');
    }

    // Remove the specified resource from storage.
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('/posts')->with('success', 'Post deleted successfully.');
    }
}
