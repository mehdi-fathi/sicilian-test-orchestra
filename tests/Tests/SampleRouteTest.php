<?php

namespace Tests;


use App\Http\Requests\UserPreferenceStoreRequest;
use BlindFoldTest\FakerrData;
use BlindFoldTest\RequestStrategyTestable;
use BlindFoldTest\SampleController;
use Tests\Tests\Request\RequestStrategyList;

/**
 *
 */
class SampleRouteTest extends TestCase
{
    use RequestStrategyTestable;

    private $data;
    private $requests;

    private $fakeData;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->fakeData = new FakerrData();
        $this->requests = (new RequestStrategyList())->getRequests();
    }

    public function mockdata($data, $request, $route)
    {

        $method = $request['method'];

        if (!empty($method)) {

            $this->mockDataInner($request['call']);
            foreach ($request['next'] as $item) {
                $this->mockDataInner($item['call'], $item['should_see'] ?? []);
            }
        }

    }

    /**
     * @param int $call
     * @param array $should_see
     * @return void
     */
    private function mockDataInner($call = 1, $should_see = []): void
    {

        for ($i = 0; $i < $call; $i++) {

            if (!empty($should_see)) {

                foreach ($should_see['should_see'] as $item) {
                    $name[] = $this->data[$should_see['pre_route']][$item];

                }
            }

            if (!empty($name)) {

                $mock = \Mockery::mock('overload:App\Models\User');
                $mock->shouldReceive('get')
                    ->andReturn($name);

            }

        }
    }


    //

}
