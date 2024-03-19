<?php

namespace SicilianTestOrchestra;


use App\Http\Requests\UserPreferenceStoreRequest;
use App\Models\User;
use SicilianTestOrchestra\Request\StrategyRequestList;
use SicilianTestOrchestra\SampleController;
use Tests\TestCase;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;
use Tests\Tests\Model\ReportTest;

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

    protected $request;

    protected $reportId;

    /**
     * @param mixed $reportId
     */
    public function setReportId($reportId)
    {
        $this->reportId = $reportId;
    }

    /**
     * @return mixed
     */
    public function getReportId()
    {
        return $this->reportId;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getRequest($key)
    {
        return $this->request[$key];
    }


    /**
     * @param $key
     * @param $data
     */
    public function setRequestKey($key, $data)
    {
        $this->request[$key] = $data;
    }

    /**
     * @param $key
     * @param $data
     */
    public function setRequestKeyPush($key, $data)
    {
        $this->request[$key][] = $data;
    }


    /** @test */
    public function test_all_routes_sicilian_test_orchetra_response()
    {
        $this->table = new Table(new ConsoleOutput());
        $this->table->setHeaders(['Order', 'Route', 'Method', 'Data', 'Status', 'Response']);

        $this->fakeData = new FakerData();

        $this->table->setHeaderTitle('Sicilian Test Orchestra');

        $this->table->setStyle('default');

        $this->setReportId(strtotime(now()));

        $this->processRoute($this->testOrchestraRequests);
        $this->table->render();

        self::assertTrue(true);


    }

    /**
     * @param $request
     * @return void
     */
    public function processRoute($request)
    {

        $this->setRequest($request);

        if (in_array('auth', $this->getRequest('user_login'))) {
            $this->signIn();
        }

        $this->makeCallShuffle();

        $this->sendRequests();
    }

    /**
     * @param $route
     * @param $method
     * @param $data
     * @param int $call
     * @param array $param
     * @return void
     */
    private function processRequest($route, $method, $data, int $call = 1, array $param = []): void
    {

        for ($i = 0; $i < $call; $i++) {

            $data_new = $param_new = [];
            if (!empty($data)) {
                $data_new = $this->fakeData->generateFakeData($data);
                $this->data[$route] = $data_new;
            }

            if (!empty($param)) {
                $param_new = $this->fakeData->generateFakeData($param);
            }

            $this->orderCount = $this->orderCount + 1;

            if ($method == 'get') {

                $uri = route($route, $data_new ?? []);

                $response = $this->get($uri);

            } elseif ($method == 'put') {
                $uri = route($route, $param_new);

                $response = $this->put($uri, $data_new);

            } else {

                $uri = $route;

                $response = $this->{$method}($route, $data_new);
            }

            $data_table = !empty($data) ? substr(json_encode($data_new), 0, 20) : "";

            $response_body = $response->getContent();

            $mini_content = !empty($response_body) ? substr($response_body, 0, 40) : "";

            $status = $response->getStatusCode();

            if ($status == 404) {
                $status_command = "\033[38;5;208m$status\033[0m";
            } elseif ($status >= 500) {
                $status_command = "\033[31m$status\033[0m";
            } elseif ($status == 200) {
                $status_command = "\033[32m$status\033[0m";

            }

            ReportTest::query()->forceCreate([
                'report_id' => $this->getReportId(),
                'order' => $this->orderCount,
                'route' => $route,
                'method' => $method,
                'request' => $data_table,
                'status' => (int)$status,
                'response' => $response_body,
            ]);

            $this->table->addRow(
                [$this->orderCount, $route, $method, $data_table, $status_command, $mini_content],
            );
        }
    }

    /**
     * @param \App\Models\User|null $user
     * @return $this
     */
    protected function signIn($user = null)
    {
        $user = $user ?: $this->create(User::class);

        $user->saveQuietly();

        $this->actingAs($user);

        return $this;
    }

    /**
     * @param $class
     * @param array $attributes
     * @param null $times
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    function create($class, $attributes = [], $times = null)
    {
        if ($class == \App\Models\User::class) {
            if ($times) {
                return $class::factory()->count($times)->create($attributes);
            } else {
                return $class::factory()->create($attributes);
            }
        }

        return factory($class, $times)->create($attributes);
    }

    /**
     * @return mixed
     */
    private function makeCallShuffle()
    {
        foreach ($this->getRequest('next') as $item) {

            if (!empty($item['call_shuffle'])) {

                for ($i = 0; $i < $item['call_shuffle']; $i++) {
                    $this->setRequestKeyPush('next', $item);
                }
            }
        }

        if ($this->getRequest('shuffle_next')) {
            $next = $this->getRequest('next');
            shuffle($next);
            $this->setRequestKey('next', $next);
        }

    }

    /**
     * @return void
     */
    private function sendRequests(): void
    {
        foreach ($this->getRequest('next') as $item) {

            $this->mockDataInner($item);

            $this->processRequest(
                route: $item['route'],
                method: $item['method'],
                data: $item['data'] ?? null,
                call: $item['call'],
                param: $item['param'] ?? []);
        }
    }


}
