<?php

namespace SicilianTestOrchestra;


use App\Http\Requests\UserPreferenceStoreRequest;
use App\Models\User;
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
        $this->table = new Table(new ConsoleOutput());
        $this->table->setHeaders(['Order', 'Route', 'Method', 'Data', 'Status', 'Response']);

        $this->table->setHeaderTitle('Test ');

        $this->table->setStyle('default');

        $this->processRoute($this->requests);
        $this->table->render();

        self::assertTrue(true);


    }

    /**
     * @param $request
     * @return void
     */
    public function processRoute($request)
    {

        if (in_array('auth', $request['user_login'])) {
            $this->signIn();
        }

        foreach ($request['next'] as $item) {

            if (!empty($item['call_shuffle'])) {

                for ($i = 0; $i < $item['call_shuffle']; $i++) {
                    $request['next'][] = $item;
                }
            }

        }

        if ($request['shuffle_next']) {
            shuffle($request['next']);
        }

        foreach ($request['next'] as $item) {

            $this->mockDataInner($item);
            $this->processRequest($item['route'], $item['method'], $item['data'] ?? null, $item['call'], $item['see'] ?? [], $item['param'] ?? []);
        }
    }

    /**
     * @param $route
     * @param $method
     * @param $data
     * @param int $call
     * @param array $see
     * @param $param
     * @return void
     */
    private function processRequest($route, $method, $data, $call = 1, $see = [], $param = []): void
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

            if (!empty($see)) {

                $name = [];
                foreach ($see['should_see'] as $item) {
                    if (!empty($this->data[$see['pre_route']])) {
                        $name[] = $this->data[$see['pre_route']][$item];
                    }
                }
            }

            if ($method == 'get') {

                $route_req = route($route, $data_new ?? []);

                $response = $this->get($route_req);

            } elseif ($method == 'put') {

                $response = $this->put(route($route, $param_new), $data_new);

            } else {

                $response = $this->{$method}($route, $data_new);
            }

            $data_table = !empty($data) ? substr(json_encode($data_new), 0, 20) : "";
            $content = !empty($response->getContent()) ? substr($response->getContent(), 0, 20) : "";

            $status = $response->getStatusCode();
            if ($status == 404) {
                $status = "\033[38;5;208m$status\033[0m";
            } elseif ($status >= 500) {
                $status = "\033[31m$status\033[0m";
            } elseif ($status == 200) {
                $status = "\033[32m$status\033[0m";

            }

            $this->table->addRow(
                [$this->orderCount, $route, $method, $data_table, $status, $content],
            );

            // $response->assertStatus($should_status);

            if (!empty($see)) {

                if (!empty($name)) {
                    // $response->assertSee($name);
                }
            }
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


}
