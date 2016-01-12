<?php

namespace MenuBundle\Twig;


use Symfony\Component\DependencyInjection\ContainerInterface;

class MenuExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * TwigExtension constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'menubundle_extension';
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('deadkashmenubundle_render', array($this, 'render'), array('is_safe' => array('html'))),
        );
    }

    /**
     * @param string $type
     * @return string
     */
    public function render($type)
    {
        return $this->container->get('menubundle')->buildMenu($type);
    }
}