<?php

namespace Tests;



use BlindFoldTest\SampleController;

class SampleRouteTest extends \TestCase
{
    /** @test */
    public function it_returns_sample_response()
    {

        // dd($controller);
        // $response = $controller->index();

        $res = $this->get('sample');

        dd($res->getContent());

        // $this->assertEquals('This is a sample controller response');
    }
}
