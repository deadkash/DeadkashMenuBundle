<?php

namespace Deadkash\MenuBundle;


use Deadkash\MenuBundle\DependencyInjection\DeadkashMenuExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DeadkashMenuBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new DeadkashMenuExtension();
    }
}