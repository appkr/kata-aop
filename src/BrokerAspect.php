<?php

namespace KataAop;

use Go\Aop\Aspect;
use Go\Aop\Intercept\FieldAccess;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\After;
use Go\Lang\Annotation\AfterThrowing;
use Go\Lang\Annotation\Around;
use Go\Lang\Annotation\Before;
use Go\Lang\Annotation\DeclareParents;
use Go\Lang\Annotation\Pointcut;

class BrokerAspect implements Aspect
{
    /**
     * @param MethodInvocation $invocation Invocation
     * @Before("execution(public Hello->*(*))")
     */
    public function beforeMethodExecution(MethodInvocation $invocation)
    {
        echo "Entering method " . $invocation->getMethod()->getName() . "()\n";
    }

    /**
     * @param MethodInvocation $invocation Invocation
     * @After("execution(public Hello->*(*))")
     */
    public function afterMethodExecution(MethodInvocation $invocation)
    {
        echo "Finished executing method " . $invocation->getMethod()->getName() . "()\n";
        echo "with parameters: " . implode(', ', $invocation->getArguments()) . ".\n\n";
    }

    /**
     * @param MethodInvocation $invocation Invocation
     * @Around("execution(public Hello->*(*))")
     * @return mixed
     */
    public function aroundMethodExecution(MethodInvocation $invocation) {
        $returned = $invocation->proceed();
        echo "method returned: " . $returned . "\n";

        return $returned;
    }

    /**
     * @param MethodInvocation $invocation Invocation
     * @AfterThrowing("execution(public Hello->*(*))")
     */
    public function afterExceptionMethodExecution(MethodInvocation $invocation) {
        echo 'An exception has happened';
    }
}