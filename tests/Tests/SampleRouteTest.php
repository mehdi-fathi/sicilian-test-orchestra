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
    }


    //

}
