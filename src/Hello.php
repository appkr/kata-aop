<?php

namespace KataAop;

use Psr\Http\Message\ResponseInterface;

class Hello
{
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function __invoke(): ResponseInterface
    {
        $response = $this->response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['message' => 'Hello Aop']));
        return $response;
    }
}