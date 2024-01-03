<?php

namespace BlindFoldTest\Request;

class StrategyRequestList
{

    protected $requests = [
        "save" => [
            'method' => 'post',
            'data' => [
                'name' => ['required', 'string', 'min:1', 'max:4'],
                'email' => ['required', 'email', 'min:1', 'max:40'],
                'from_date' => ['required', 'date', 'from:', 'to:'],
                'age' => ['required', 'numeric', 'min:1', 'max:8'],
                'has_job' => ['required', 'boolean'],
                'favorite_colors' => ['required', 'array'],
            ],
            'should_status' => 200,
            'call' => 10,
            'next' => [
                [
                    'route' => 'sample',
                    'method' => 'get',
                    'data' => [],
                    'should_status' => 200,
                    'should_see' => [
                            'pre_route' => 'save',
                            'should_see' => ['name'],
                    ],
                    'call' => 1,
                ],
                [
                    'route' => 'sample',
                    'method' => 'get',
                    'data' => [],
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
