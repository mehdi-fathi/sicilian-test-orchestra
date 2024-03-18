<?php

namespace Tests\Tests\Request;


class RequestStrategyList
{

    protected $requests = [
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
                'call' => 1,
                'call_shuffle' => 2,
            ],
            [
                'route' => 'list',
                'method' => 'get',
                'data' => [],
                'call' => 1,
                'call_shuffle' => 2,
            ],
            [
                'route' => 'list',
                'method' => 'get',
                'data' => [],
                'call' => 1,
                'call_shuffle' => 2,
            ],
            [
                'route' => 'show',
                'method' => 'get',
                'data' => [
                    'id' => ['numeric', 'min:1', 'max:1']
                ],
                'call' => 1,
                'call_shuffle' => 2,
            ],
            [
                'route' => 'destroy',
                'method' => 'get',
                'data' => [
                    'id' => ['numeric', 'min:1', 'max:1']
                ],
                'call' => 1,
                'call_shuffle' => 2,
            ],
            [
                'route' => 'show',
                'method' => 'get',
                'data' => [
                    'id' => ['numeric', 'min:1', 'max:1']
                ],
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
