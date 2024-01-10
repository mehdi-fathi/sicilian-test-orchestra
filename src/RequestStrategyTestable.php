<?php

namespace SicilianTestOrchestra;


use App\Http\Requests\UserPreferenceStoreRequest;
use SicilianTestOrchestra\FakerrData;
use SicilianTestOrchestra\Request\StrategyRequestList;
use SicilianTestOrchestra\SampleController;
use Tests\TestCase;

/**
 *
 */
trait RequestStrategyTestable
{

    private $data;

    private $fakeData;

    /** @test */
    public function it_returns_sample_response()
    {
        // $requests = (new StrategyRequestList())->getRequests();

        foreach ($this->requests as $route => $request) {
            $this->processRoute($route, $request);
        }

    }

    /**
     * @param $route
     * @param $request
     * @return void
     */
    public function processRoute($route, $request)
    {

        $method = $request['method'];

        if (!empty($method)) {
            $data = $this->fakeData->generateFakeData($request['data']);

            $this->data[$route] = $data;

            $this->mockdata($data, $request, $route);

            $this->processRequest($route, $request['method'], $request['should_status'], $data, $request['call']);

            foreach ($request['next'] as $item) {
                $data = $this->fakeData->generateFakeData($item['data']);
                $this->processRequest($item['route'], $item['method'], $request['should_status'], $data, $item['call'], $item['see'] ?? []);
            }
        }
    }

    /**
     * @param $route
     * @param $method
     * @param $should_status
     * @param $data
     * @param int $call
     * @param null $see
     * @return void
     */
    private function processRequest($route, $method, $should_status, $data, $call = 1, $see = [])
    {

        for ($i = 0; $i < $call; $i++) {


            if (!empty($see)) {

                foreach ($see['should_see'] as $item) {
                    $name[] = $this->data[$see['pre_route']][$item];
                }
            }


            if ($method == 'get') {
                dump($route);

                $route_req = route($route, $data ?? []);

                $response = $this->get($route_req);

            } else {

                $response = $this->{$method}($route, $data);
            }

            $response->assertStatus($should_status);

            if (!empty($see)) {

                if (@$see['how_see'] == 'array') {
                    $response->assertJsonIsObject();
                }

                $response->assertSee($name);
            }
        }
    }

    public function mockdata($call = 1, $should_see = []): void
    {
    }

}
