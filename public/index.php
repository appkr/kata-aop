<?php

use function DI\create;
use function FastRoute\simpleDispatcher;
use DI\ContainerBuilder;
use FastRoute\RouteCollector;
use KataAop\ApplicationAspectKernel;
use KataAop\Hello;
use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Relay\Relay;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(true);
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions([
//    Hello::class => create(Hello::class), // autowire=false 이면 생성자의 파라미터를 모두 정의해야 함.
    ResponseInterface::class => function () {
        return new Response();
    },
]);
$container = $containerBuilder->build();

$applicationAspectKernel = ApplicationAspectKernel::getInstance();
$applicationAspectKernel->init([
    'debug' => true,
    'appDir' => __DIR__ . '/..',
    'cacheDir' => __DIR__ . '/../cache',
    'includePaths' => [
        __DIR__ . '/../src/'
    ]
]);

$routeDispatcher = simpleDispatcher(function (RouteCollector $r) {
    $r->get('/hello', Hello::class);
});

$middlewareQueue = [];
$middlewareQueue[] = new FastRoute($routeDispatcher);
$middlewareQueue[] = new RequestHandler($container);
$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

$emitter = new SapiEmitter();
return $emitter->emit($response);
