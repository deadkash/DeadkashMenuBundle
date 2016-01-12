<?php

namespace Deadkash\MenuBundle;


use MenuBundle\DependencyInjection\MenuExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MenuBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new MenuExtension();
    }
}