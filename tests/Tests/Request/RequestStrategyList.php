<?php

namespace Tests\Tests\Request;


class RequestStrategyList
{

    //todo we should be able to declare some bunches of requests
    protected $requests = [
        // 'method' => 'post',
        // 'data' => [
        //     'name' => ['string', 'min:1', 'max:4'],
        //     'email' => ['email', 'min:1', 'max:40'],
        //     'from_date' => ['date', 'from:', 'to:'], //todo set from & to
        //     'age' => ['numeric', 'min:1', 'max:8'],
        //     'has_job' => ['boolean'],
        //     'favorite_colors' => ['array'],
        // ],
        // 'should_status' => 200,
        // 'call' => 10,
        'user_login' => ['auth'],  //auth,quest
        'shuffle_next' => true,
        'next' => [
            [
                'route' => 'save',
                'method' => 'post',
                'data' => [
                    // 'name' => ['string', 'min:1', 'max:4'],
                    'body' => ['string', 'min:1', 'max:4'],
                    // 'email' => ['email', 'min:1', 'max:40'],
                    // 'from_date' => ['date', 'from:', 'to:'], //todo set from & to
                    // 'age' => ['numeric', 'min:1', 'max:8'],
                    // 'has_job' => ['boolean'],
                    // 'favorite_colors' => ['array'],
                ],
                'should_status' => 200,
                'call' => 1,
                'call_shuffle' => 5,
            ],
            [
                'route' => 'update',
                'method' => 'put',
                'data' => [
                    'body' => ['string', 'min:1', 'max:4'],
                ],
                'param' => [
                    'id' => ['numeric', 'min:1', 'max:1']
                ],
                'should_status' => 200,
                'call' => 1,
                'call_shuffle' => 2,
            ],
            [
                'route' => 'list',
                'method' => 'get',
                'data' => [],
                'should_status' => 200,
                'see' => [
                    'pre_route' => 'save',
                    'should_see' => ['body'],
                ],
                'call' => 1,
                'call_shuffle' => 2,
            ],
            [
                'route' => 'list',
                'method' => 'get',
                'data' => [],
                'should_status' => 200,
                'call' => 1,
                'call_shuffle' => 2,
            ],
            [
                'route' => 'show',
                'method' => 'get',
                'data' => [
                    'id' => ['numeric', 'min:1', 'max:1']
                ],
                'see' => [
                    'pre_route' => 'save',
                    'should_see' => ['body'],
                ],
                'should_status' => 200,
                'call' => 1,
                'call_shuffle' => 2,
            ],
            [
                'route' => 'destroy',
                'method' => 'get',
                'data' => [
                    'id' => ['numeric', 'min:1', 'max:1']
                ],
                'should_status' => 200,
                'call' => 1,
                'call_shuffle' => 2,
            ],
            [
                'route' => 'show',
                'method' => 'get',
                'data' => [
                    'id' => ['numeric', 'min:1', 'max:1']
                ],
                'should_status' => 404,
                'call' => 1,
                'call_shuffle' => 2,

            ],
        ]
    ];


    /**
     * @return mixed
     */
    public function getRequests()
    {
        return $this->requests;
    }

}
