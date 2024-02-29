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

    private $is_destroy = false;

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

            $this->mockDataInner($request);
            foreach ($request['next'] as $item) {
                $this->mockDataInner($item);
            }
        }

    }

    /**
     * @param $items
     * @return void
     */
    public function mockDataInner($items): void
    {

        return ;
        // dump($items['route'] ?? null, 'item');

        $call = (int)$items['call'];
        $see = $items['see'] ?? null;


        // Create a mock instance of the Post model
        $mockPost = \Mockery::mock('overload:Tests\Tests\Model\Comment');

        $mockPost->shouldReceive('find')->with(1)->andReturn([]);

        $mockPost->shouldReceive('destroy')
            ->once()
            ->with(1)
            ->andReturn(true);


        $mock = \Mockery::mock('overload:App\Models\User');
        $mock->shouldReceive('get')
            ->andReturn([]);


        for ($counter_call = 0; $counter_call < $call; $counter_call++) {


            if (!empty($see)) {

                foreach ($see['should_see'] as $item) {

                    if (!empty($this->data[$see['pre_route']])) {
                        $name[] = $this->data[$see['pre_route']][$item];

                    }
                }
            }

            if (!empty($name) && $items['route'] == 'list') {
                \Mockery::resetContainer();

                $mock = \Mockery::mock('overload:App\Models\User');
                $mock->shouldReceive('get')
                    ->andReturn($name);

            }

            if (!empty($items['route']) && !empty($name) && $items['route'] == 'show') {

                \Mockery::resetContainer();

                // Create a mock instance of the Post model
                $mockPost = \Mockery::mock('overload:Tests\Tests\Model\Comment');

                $mockPost->shouldReceive('find')->with(1)->andReturn($name[0]);

                $mockPost->shouldReceive('destroy')
                    ->once()
                    ->with(1)
                    ->andReturn(true);
            }
            // dump( $items);

            if (!empty($items['route']) && $items['route'] == 'destroy') {

                \Mockery::resetContainer();

                $mockPost = \Mockery::mock('overload:Tests\Tests\Model\Comment');

                // Mock the 'find' method to return the mockPost when a specific ID is queried

                // Mock the 'find' method to return the mockPost when a specific ID is queried
                // $mockPost1->shouldReceive('destroy')->with(1)->andReturn();
                $mockPost->shouldReceive('destroy')
                    ->once()
                    ->with(1)
                    ->andReturn(true);

                $this->is_destroy = true;

            }

            if (!empty($items['route']) && $items['route'] == 'update') {

                \Mockery::resetContainer();

                $mockPost1 = \Mockery::mock('overload:Tests\Tests\Model\Comment');

                $mockPost1->shouldReceive('find')->with(1)->andReturn([]);

                $mockPost1->shouldReceive('update')
                    ->andReturn(true);

            }

            if ($this->is_destroy && $items['route'] == 'show') {

                \Mockery::resetContainer();
                $mockPost = \Mockery::mock('overload:Tests\Tests\Model\Comment');

                $mockPost->shouldReceive('find')->with(1)->andReturn([]);


            }

        }
    }


    //

}
