<?php

namespace MenuBundle;


use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouteCollection;

class MenuBundleLoader implements LoaderInterface
{
    /** @var bool  */
    private $loaded = false;

    /** @var ContainerInterface  */
    private $container;

    /**
     * ExtraLoader constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param mixed $resource
     * @param null $type
     * @return RouteCollection
     */
    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add this loader twice');
        }

        return $this->container->get('deadkashmenubundle')->buildRoutes();
    }

    /**
     * @param mixed $resource
     * @param null $type
     * @return bool
     */
    public function supports($resource, $type = null)
    {
        return 'deadkashmenubundle' === $type;
    }

    public function getResolver() {}

    public function setResolver(LoaderResolverInterface $resolver) {}
}