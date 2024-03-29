<?php

namespace Tests;


use App\Http\Requests\UserPreferenceStoreRequest;
use SicilianTestOrchestra\FakerData;
use SicilianTestOrchestra\RequestStrategyTestable;
use Tests\Tests\Model\Comment;
use Tests\Tests\Request\RequestStrategyList;

/**
 *
 */
class SampleRouteTest extends TestCase
{
    use RequestStrategyTestable;

    /**
     * @var array|mixed
     */
    private mixed $testOrchestraRequests;

    /**
     *
     */

    public function setUp(): void
    {
        parent::setUp();

        $this->testOrchestraRequests = (new RequestStrategyList())->getRequests();
    }

}
