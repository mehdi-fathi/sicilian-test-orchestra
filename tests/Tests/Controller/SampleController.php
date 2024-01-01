<?php

namespace Tests\Tests\Controller;


use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class SampleController extends BaseController
{

    use AuthorizesRequests;
    use ValidatesRequests;

    public function index()
    {
        $activeUsers = User::get();

        // If you're building an API, you might return JSON:
        return response()->json(['users' => $activeUsers]);
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

        return 'This is a sample controller response';
    }
}
