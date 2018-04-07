<?php

use DI\ContainerBuilder;
use KataAop\Hello;
use function DI\create;

require_once __DIR__.'/../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions([
    Hello::class => create(Hello::class),
]);

$container = $containerBuilder->build();

$hello = $container->get(Hello::class);
echo $hello->aop();