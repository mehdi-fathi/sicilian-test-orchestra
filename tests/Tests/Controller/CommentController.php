<?php

namespace Tests\Tests\Controller;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tests\Tests\Model\Comment;

/**
 *
 */
class CommentController extends BaseController
{

    use AuthorizesRequests;
    use ValidatesRequests;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        $comments = Comment::query()->paginate();

        return response()->json(['data' => $comments]);
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        $rules = [
            'body' => ['required', 'string', 'min:1', 'max:40'],
        ];

        // $rules = [
        //     'name' => ['required', 'string', 'min:1', 'max:4'],
        //     'email' => ['required', 'email', 'min:1', 'max:40'],
        //     'from_date' => ['required', 'date'],
        //     'age' => ['required', 'numeric', 'min:1', 'max:8'],
        //     'has_job' => ['required', 'boolean'],
        //     'favorite_colors' => ['required', 'array']
        // ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Alternatively, you can return the errors as a response
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $comment = new Comment();

        $comment->body = $request->get('body');

        $comment->user_id = auth()->id();

        $comment->save();

        return response()->json(['message' => 'The comment has been saved.']);

    }


    // Display the specified resource.

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $comment = Comment::find($id);
        if (empty($comment)) {
            return response('', 404);
        }
        return response()->json(['data' => $comment]);
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
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $comment = Comment::destroy($id);
        return response()->json(['deleted']);

    }

    // Update the specified resource in storage.

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {

        $rules = [
            'body' => ['required', 'string', 'min:1', 'max:40'],
        ];

        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            // Alternatively, you can return the errors as a response
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $comment = Comment::query()->findOrFail($id);

        $comment->body = request()->get('body');

        $comment->save();

        return response()->json(['message' => 'The comment has been updated successfully.']);
    }
}
