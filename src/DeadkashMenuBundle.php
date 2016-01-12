<?php

namespace Deadkash\MenuBundle;


use Deadkash\MenuBundle\DependencyInjection\MenuExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DeadkashMenuBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new MenuExtension();
    }
}