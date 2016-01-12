<?php

namespace Deadkash\MenuBundle;


use Deadkash\MenuBundle\DependencyInjection\MenuExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MenuBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new MenuExtension();
    }
}