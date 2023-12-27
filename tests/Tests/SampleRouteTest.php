<?php

namespace Tests;


use App\Http\Requests\UserPreferenceStoreRequest;
use BlindFoldTest\SampleController;
use Faker\Factory as Faker;
use Illuminate\Routing\Router;
use Tests\Tests\Controller\Request\RequestTest;

class SampleRouteTest extends \TestCase
{
    /** @test */
    public function it_returns_sample_response()
    {

        // dd($controller);
        // $response = $controller->index();

        $res = $this->get('sample');

        // dd($res->getContent());

        // $this->assertEquals('This is a sample controller response');


        $routes = app(Router::class)->getRoutes();

        // dump($routes->getRoutes()[0],$routes);

        $requests = (new RequestTest())->getRequests();

        foreach ($routes->getRoutes() as $route) {

            switch ($route->methods[0]) {
                case "GET":

                    if (in_array($route->uri, ['api/user', '/'])) {
                        continue 2;
                    }

                    $res = $this->get($route->uri);

                    $res->assertStatus(200);

                    // dump($res->getStatusCode(), $route->uri);
                    break;

                case "POST":

                    if ($route->uri == 'api/v1/user-preference/store') {
                        continue 2;
                    }

                    // dd($route->uri, $requests[$route->uri]);

                    $req = $requests[$route->uri];
                    // $arguments = func_get_args();

                    // $request = new Tests\Controller\Request\UserPreferenceStoreRequest();
                    //
                    // $rules = $request->rules();

                    $this->requests = $req;

                    $total = 0;
                    $green = "\033[32m";

                    while ($total < $this->requests['call']) {

                        $data = $this->generateFakeData($this->requests['data']);

                        $res = $this->post($route->uri, $data);

                        $this->showData($green, $data);

                        $total++;
                        $res->assertStatus($this->requests['should_status']);

                    }

                    foreach ($this->requests['next'] as $item) {

                        $data = $this->generateFakeData($this->requests['data']);

                        // dd(route($item['route']));

                        $res = $this->get($item['route'], $data);

                        $this->showData($green, $data);

                        $res->assertStatus($item['should_status']);
                    }


                    // dd($validator);

                    // dd();
                    // dump($res->getStatusCode(), $route->uri, $data);
                    break;
                default:
                    break;
            }


            // dd(json_decode($res->getBody()->getContents(), true));
            //
            // dump($route->uri);
            // echo $route->getPath() . ' - ' . $route->getActionName() . PHP_EOL;
        }

        // dd("run");
    }

    public function generateFakeData($data)
    {
        $fakeData = [];

        foreach ($data as $field => $rules) {
            $fakeData[$field] = $this->generateFieldData($rules);
        }

        return $fakeData;
    }

    protected function generateFieldData($rules)
    {
        $faker = Faker::create();

        foreach ($rules as $rule) {
            if (str_contains($rule, 'string')) {
                return $this->generateFakeWord($this->extractMin($rules), $this->extractMax($rules));
            }
            if (str_contains($rule, 'email')) {
                return $faker->email($this->extractMin($rules), $this->extractMax($rules));
            }

            if (str_contains($rule, 'date')) {
                return $faker->date();
            }

            if (str_contains($rule, 'numeric')) {
                return $faker->numberBetween($this->extractMin($rules), $this->extractMax($rules));
            }

            // Handling boolean
            if (str_contains($rule, 'boolean')) {
                return $faker->boolean;
            }

            // Handling array
            if (str_contains($rule, 'array')) {
                return $faker->words; // Returns an array of words
            }

        }
    }

    function generateFakeWord($minLength, $maxLength)
    {
        $faker = Faker::create();
        do {
            $word = $faker->word;
        } while (strlen($word) < $minLength || strlen($word) > $maxLength);

        return $word;
    }

    protected function extractMin($rules)
    {
        foreach ($rules as $rule) {
            if (str_starts_with($rule, 'min:')) {
                return (int)substr($rule, 4);
            }
        }
        return 1; // Default minimum
    }

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
