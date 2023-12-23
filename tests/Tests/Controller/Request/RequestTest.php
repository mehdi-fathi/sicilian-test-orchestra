<?php

namespace Tests\Tests\Controller\Request;

class RequestTest
{

    protected $requests = [
        "save" => [
            'data' => [
                'name' => ['required', 'string', 'min:1', 'max:4'],
                'email' => ['required', 'email', 'min:1', 'max:40'],
                'from_date' => ['required', 'date','from:','to:'],
                'age' => ['required', 'numeric', 'min:1', 'max:8'],
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
