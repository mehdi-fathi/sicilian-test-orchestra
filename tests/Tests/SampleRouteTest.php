<?php

namespace Tests;


use App\Http\Requests\UserPreferenceStoreRequest;
use BlindFoldTest\FakerrData;
use BlindFoldTest\Request\StrategyRequestList;
use BlindFoldTest\SampleController;

/**
 *
 */
class SampleRouteTest extends \TestCase
{

    private $data;

    private $fakeData;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->fakeData = new FakerrData();
    }

    /** @test */
    public function it_returns_sample_response()
    {
        $requests = (new StrategyRequestList())->getRequests();

        foreach ($requests as $route => $request) {
            $this->processRoute($route, $request);
        }

    }

    /**
     * @param $route
     * @param $request
     * @return void
     */
    private function processRoute($route, $request)
    {
        // if ($this->isSkippableRoute($route)) {
        //     return;
        // }

        $method = $request['method'];

        if (!empty($method)) {
            // $this->processGetRequest($request);
            $data = $this->fakeData->generateFakeData($request['data']);
            $this->data[$route] = $data;
            $this->processRequest($route, $request['method'], $request['should_status'], $data, $request['call']);

            foreach ($request['next'] as $item) {
                $data = $this->fakeData->generateFakeData($request['data']);
                $this->processRequest($item['route'], $item['method'], $request['should_status'], $data, $item['call'], $item['should_see'] ?? []);
            }
        }
    }

    /**
     * @param $route
     * @param $method
     * @param $should_status
     * @param $data
     * @param int $call
     * @param null $should_see
     * @return void
     */
    private function processRequest($route, $method, $should_status, $data, $call = 1, $should_see = [])
    {

        for ($i = 0; $i < $call; $i++) {


            if (!empty($should_see)) {

                foreach ($should_see['should_see'] as $item) {
                    // dd($item);
                    $name[] = $this->data[$should_see['pre_route']][$item];

                }

                // dd($should_see['pre_route'], $this->data[$should_see['pre_route']]);
            }

            if (!empty($name)) {

                $mock = \Mockery::mock('overload:App\Models\User');
                $mock->shouldReceive('get')
                    ->andReturn($name);

            }


            //@see
            $response = $this->{$method}($route, $data);
            $response->assertStatus($should_status);

            if (!empty($should_see)) {

                // dd($name);
                $response->assertSee($name);

                // $this->post()->assertSee()
            }
        }
    }
    //

}
