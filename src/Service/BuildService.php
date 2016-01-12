<?php

namespace Deadkash\MenuBundle\Service;


use Exception;
use Deadkash\MenuBundle\MenuItem;
use Deadkash\MenuBundle\MenuSourceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class BuildService
{
    const MENUBUNDLE_SOURCE     = 'deadkashmenubundle.source';
    const MENUBUNDLE_TEMPLATES  = 'deadkashmenubundle.templates';
    const DEFAULT_TEMPLATE      = 'MenuBundle::menu.html.twig';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * BuildService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return MenuSourceInterface
     * @throws Exception
     */
    private function getSource()
    {
        if (!$this->container->hasParameter(self::MENUBUNDLE_SOURCE)) {
            throw new Exception('Parameter "'.self::MENUBUNDLE_SOURCE.'" not found.');
        }

        $sourceServiceName = $this->container->getParameter(self::MENUBUNDLE_SOURCE);
        if (!$sourceServiceName) {
            throw new Exception('Parameter "'.self::MENUBUNDLE_SOURCE.'" cannot be empty.');
        }

        /** @var MenuSourceInterface $source */
        $source = $this->container->get($sourceServiceName);
        if (!$source instanceof MenuSourceInterface) {
            throw new Exception('Source must be instance of MenuSourceInterface.');
        }

        return $source;
    }

    /**
     * @return RouteCollection
     * @throws Exception
     */
    public function buildRoutes()
    {
        $source = $this->getSource();

        $items = $source->getItems();
        $routes = new RouteCollection();

        /** @var MenuItem $item */
        foreach ($items as $item) {

            if (!$item instanceof MenuItem) {
                throw new Exception('Item must be instance of MenuItem class');
            }

            $pattern = $item->getPath();

            $defaults = $item->getOptions();
            $defaults['_controller'] = $item->getController();

            $route = new Route($pattern, $defaults);
            $routes->add($item->getRouteName(), $route);
        }

        return $routes;
    }

    /**
     * @param $type
     * @return string
     * @throws Exception
     * @throws \Twig_Error
     */
    public function buildMenu($type)
    {
        $templater = $this->container->get('templating');
        $templates = ($this->container->hasParameter(self::MENUBUNDLE_TEMPLATES)) ?
            $this->container->getParameter(self::MENUBUNDLE_TEMPLATES) : array();

        $template = (isset($templates[$type])) ? $templates[$type] : self::DEFAULT_TEMPLATE;

        return $templater->render($template, array(
            'items' => $this->getSource()->getTree($type),
            'type' => $type
        ));
    }

    /**
     * @param string $env
     */
    public function clearRouteCache($env = null)
    {
        $kernel = $this->container->get('kernel');
        if (!$env) $env = $kernel->getEnvironment();
        $cacheDir = $kernel->getRootDir().'/cache/'.$env;
        $urlGenerator = $cacheDir.'/app'.ucfirst($env).'UrlGenerator.php';
        $urlMatcher = $cacheDir.'/app'.ucfirst($env).'UrlMatcher.php';

        if (file_exists($urlGenerator)) {
            try {
                unlink($urlGenerator);
            } catch (Exception $e) {
            }
        }

        if (file_exists($urlMatcher)) {
            try {
                unlink($urlMatcher);
            } catch (Exception $e) {
            }
        }

        if (file_exists($urlGenerator.'.meta')) {
            try {
                unlink($urlGenerator.'.meta');
            } catch (Exception $e) {
            }
        }

        if (file_exists($urlMatcher.'.meta')) {
            try {
                unlink($urlMatcher.'.meta');
            } catch (Exception $e) {
            }
        }

        $this->container->get('router')->warmUp($this->container->getParameter('kernel.cache_dir'));
    }
}