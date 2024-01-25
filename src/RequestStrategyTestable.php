<?php

namespace SicilianTestOrchestra;


use App\Http\Requests\UserPreferenceStoreRequest;
use SicilianTestOrchestra\FakerrData;
use SicilianTestOrchestra\Request\StrategyRequestList;
use SicilianTestOrchestra\SampleController;
use Tests\TestCase;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 *
 */
trait RequestStrategyTestable
{

    private $data;
    private $table;

    private $orders;

    private $orderCount;

    private $fakeData;

    /** @test */
    public function it_returns_sample_response()
    {
        // $requests = (new StrategyRequestList())->getRequests();

        $this->table = new Table(new ConsoleOutput());
        $this->table->setHeaders(['Order', 'Route', 'Method', 'Data', 'Status', 'Response']);

        $this->table->setHeaderTitle('Test ');

        $this->table->setStyle('default');

        $this->processRoute($this->requests);
        $this->table->render();


    }

    /**
     * @param $route
     * @param $request
     * @return void
     */
    public function processRoute($request)
    {

        if ($request['shuffle_next']) {
            shuffle($request['next']);
        }

        foreach ($request['next'] as $item) {

            if (!empty($item['data'])) {

                $data = $this->fakeData->generateFakeData($item['data']);
                $this->data[$item['route']] = $data;
            }

            $this->mockDataInner($item);
            $this->processRequest($item['route'], $item['method'], $item['should_status'], $this->data[$item['route']] ?? null, $item['call'], $item['see'] ?? []);
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


            $this->orderCount = $this->orderCount + 1;

            if (!empty($see)) {

                $name = [];
                foreach ($see['should_see'] as $item) {
                    if (!empty($this->data[$see['pre_route']])) {
                        $name[] = $this->data[$see['pre_route']][$item];
                    }
                }
            }

            if ($method == 'get') {

                $route_req = route($route, $data ?? []);

                $response = $this->get($route_req);

            } else {

                $response = $this->{$method}($route, $data);
            }

            // $text = sprintf("sent request to %s got status %s with content %s", $route, $response->getStatusCode(), $response->getContent());

            $data_table = !empty($data) ? substr(json_encode($data), 0, 20) : "";

            $this->table->addRow(
                [$this->orderCount, $route, $method, $data_table, $response->getStatusCode(), $response->getContent()],
            );

            // $response->assertStatus($should_status);

            if (!empty($see)) {

                if (!empty($name)) {
                    // $response->assertSee($name);
                }
            }
        }
    }

    public function mockdata($call = 1, $should_see = []): void
    {
    }

}
//todo showing proccess sequential
