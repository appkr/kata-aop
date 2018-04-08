<?php

namespace KataAop;

use Go\Core\AspectContainer;
use Go\Core\AspectKernel;

class ApplicationAspectKernel extends AspectKernel
{
    protected function configureAop(AspectContainer $container)
    {
        $container->registerAspect(new BrokerAspect());
    }
}