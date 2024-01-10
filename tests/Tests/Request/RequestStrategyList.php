<?php

namespace Tests\Tests\Request;


class RequestStrategyList
{

    protected $requests = [
        "save" => [
            'method' => 'post',
            'data' => [
                'name' => ['string', 'min:1', 'max:4'],
                'email' => ['email', 'min:1', 'max:40'],
                'from_date' => ['date', 'from:', 'to:'], //todo set from & to
                'age' => ['numeric', 'min:1', 'max:8'],
                'has_job' => ['boolean'],
                'favorite_colors' => ['array'],
            ],
            'should_status' => 200,
            'call' => 10,
            'next' => [
                [
                    'route' => 'list',
                    'method' => 'get',
                    'data' => [],
                    'should_status' => 200,
                    'see' => [
                        'pre_route' => 'save',
                        'how_see' => 'array',
                        'should_see' => ['name'],
                    ],
                    'call' => 1,
                ],
                [
                    'route' => 'list',
                    'method' => 'get',
                    'data' => [],
                    'should_status' => 200,
                    'call' => 1,
                ],
                [
                    'route' => 'show',
                    'method' => 'get',
                    'data' => [
                        'id' => ['numeric', 'min:1', 'max:1']
                    ],
                    'see' => [
                        'pre_route' => 'save',
                        // 'how_see' => 'array',
                        'should_see' => ['name'],
                    ],
                    'should_status' => 200,
                    'call' => 2,
                ]
            ]
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
