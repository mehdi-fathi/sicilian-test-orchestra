<?php

namespace Tests;


use App\Http\Requests\UserPreferenceStoreRequest;
use BlindFoldTest\SampleController;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Tests\Tests\Controller\Request\RequestTest;

/**
 *
 */
class SampleRouteTest extends \TestCase
{
    /**
     * @var \Faker\Generator
     */
    private \Faker\Generator $faker;

    private $data;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->faker = Faker::create();
    }

    /** @test */
    public function it_returns_sample_response()
    {
        $requests = (new RequestTest())->getRequests();

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
            $data = $this->generateFakeData($request['data']);
            $this->data[$route] = $data;
            $this->processRequest($route, $request['method'], $request['should_status'], $data, $request['call']);

            foreach ($request['next'] as $item) {
                $data = $this->generateFakeData($request['data']);
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


    /**
     * @param $data
     * @return array
     */
    public function generateFakeData($data)
    {
        $fakeData = [];

        foreach ($data as $field => $rules) {
            $fakeData[$field] = $this->generateFieldData($rules);
        }

        return $fakeData;
    }

    /**
     * @param $rules
     * @return array|bool|int|string|void
     */
    protected function generateFieldData($rules)
    {
        foreach ($rules as $rule) {
            if (str_contains($rule, 'string')) {
                return $this->generateFakeWord($this->extractMin($rules), $this->extractMax($rules));
            }
            if (str_contains($rule, 'email')) {
                return $this->faker->email();
            }

            if (str_contains($rule, 'date')) {
                return $this->faker->date();
            }

            if (str_contains($rule, 'numeric')) {
                return $this->faker->numberBetween($this->extractMin($rules), $this->extractMax($rules));
            }

            // Handling boolean
            if (str_contains($rule, 'boolean')) {
                return $this->faker->boolean;
            }

            // Handling array
            if (str_contains($rule, 'array')) {
                return $this->faker->words; // Returns an array of words
            }

        }
    }

    /**
     * @param $minLength
     * @param $maxLength
     * @return string
     */
    function generateFakeWord($minLength, $maxLength)
    {
        do {
            $word = $this->faker->word;
        } while (strlen($word) < $minLength || strlen($word) > $maxLength);

        return $word;
    }

    /**
     * @param $rules
     * @return int
     */
    protected function extractMin($rules)
    {
        foreach ($rules as $rule) {
            if (str_starts_with($rule, 'min:')) {
                return (int)substr($rule, 4);
            }
        }
        return 1; // Default minimum
    }

    /**
     * @param $rules
     * @return int
     */
    protected function extractMax($rules)
    {
        foreach ($rules as $rule) {
            if (str_starts_with($rule, 'max:')) {
                return (int)substr($rule, 4);
            }
        }
        return 255; // Default maximum
    }

    /**
     * @param string $green
     * @param $data
     * @return void
     */
    private function showData(string $green, $data)
    {
        echo $green . "Test Data : " . PHP_EOL;
        print_r($data) . PHP_EOL;
    }

}
