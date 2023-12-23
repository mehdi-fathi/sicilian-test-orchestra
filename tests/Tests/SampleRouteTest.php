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
                    $data = $this->generateFakeData();

                    $res = $this->post($route->uri, $data);
                    $res->assertStatus(200);

                    // dd($validator);

                    // dd();
                    dump($res->getStatusCode(), $route->uri, $data);
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

    public function generateFakeData()
    {
        $fakeData = [];

        foreach ($this->requests as $request) {
            foreach ($request as $field => $rules) {
                $fakeData[$field] = $this->generateFieldData($rules);
            }
        }

        return $fakeData;
    }

    protected function generateFieldData($rules)
    {
        $faker = Faker::create();

        foreach ($rules as $rule) {
            if (str_contains($rule, 'string')) {
                return $faker->word($this->extractMin($rules), $this->extractMax($rules));
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
        }
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

}
