<?php

namespace Tests\Tests\Controller;


use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tests\Tests\Model\Comment;

class CommentController extends BaseController
{

    use AuthorizesRequests;
    use ValidatesRequests;

    public function list()
    {
        $comments = Comment::query()->get();

        // If you're building an API, you might return JSON:
        return response()->json(['users' => $comments]);
        // dd($this->data);
        // return response()->json($this->data, 200);
    }


    public function save(Request $request)
    {
        // dump($request->get('name'));
        $rules = [
            'name' => ['required', 'string', 'min:1', 'max:4'],
            'email' => ['required', 'email', 'min:1', 'max:40'],
            'from_date' => ['required', 'date'],
            'age' => ['required', 'numeric', 'min:1', 'max:8'],
            'has_job' => ['required', 'boolean'],
            'favorite_colors' => ['required', 'array']
        ];


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Alternatively, you can return the errors as a response
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $comment = new Comment();

        $comment->body = $request->get('body');

        $comment->user_id = 1;

        $comment->save();

        return 'This is a sample controller response';
    }


    // Display the specified resource.
    public function show($id)
    {
        $comment = Comment::find($id);
        if (empty($comment)) {
            return response('', 404);
        }
        return response()->json(['comment' => $comment]);
    }

    //
    // // Show the form for editing the specified resource.
    // public function edit(Post $post)
    // {
    //     return view('posts.edit', compact('post'));
    // }
    //
    // // Update the specified resource in storage.
    // public function update(Request $request, Post $post)
    // {
    //     $validatedData = $request->validate([
    //         'title' => 'required|max:255',
    //         'body' => 'required',
    //     ]);
    //
    //     $post->update($validatedData);
    //
    //     return redirect('/posts')->with('success', 'Post updated successfully.');
    // }
    //
    // // Remove the specified resource from storage.
    public function destroy($id)
    {
        $comment = Comment::destroy($id);
        return response()->json(['deleted']);

    }

    // Update the specified resource in storage.
    public function update($id)
    {
        return response()->json(['updated']);
    }
}
