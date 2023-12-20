<?php
namespace BlindFoldTest\Controller;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class SampleController extends BaseController
{

    use AuthorizesRequests;
    use ValidatesRequests;

    public function index()
    {
        return 'This is a sample controller response';
    }
}
