<?php

namespace Tests;


use App\Http\Requests\UserPreferenceStoreRequest;
use SicilianTestOrchestra\FakerrData;
use SicilianTestOrchestra\RequestStrategyTestable;
use Tests\Tests\Model\Comment;
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
                $this->mockDataInner($item['call'], $item['see'] ?? []);
            }
        }

    }

    /**
     * @param int $call
     * @param array $should_see
     * @return void
     */
    private function mockDataInner($call = 1, $see = []): void
    {

        for ($counter_call = 0; $counter_call < $call; $counter_call++) {

            if (!empty($see)) {

                foreach ($see['should_see'] as $item) {

                    $name[] = $this->data[$see['pre_route']][$item];

                }
            }

            if (!empty($name)) {

                $mock = \Mockery::mock('overload:App\Models\User');
                $mock->shouldReceive('get')
                    ->andReturn($name);

                // Create a mock instance of the Post model
                $mockPost = \Mockery::mock('overload:Tests\Tests\Model\Comment');

                // Mock the 'find' method to return the mockPost when a specific ID is queried
                $mockPost->shouldReceive('find')->with(1)->andReturn($name[0]);

            }

        }
    }


    //

}
