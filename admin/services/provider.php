<?php

\defined('_JEXEC') or die;

use FooSpace\Component\Foobar\Administrator\Extension\FoobarComponent;
use Joomla\CMS\Component\Router\RouterFactoryInterface;
use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\Extension\Service\Provider\RouterFactory;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

return new class () implements ServiceProviderInterface 
{
    public function register(Container $container)
    {
        $container->registerServiceProvider(new MVCFactory('\\FooSpace\\Component\\Foobar'));
        $container->registerServiceProvider(new ComponentDispatcherFactory('\\FooSpace\\Component\\Foobar'));
        $container->registerServiceProvider(new RouterFactory('\\FooSpace\\Component\\Foobar'));
        $container->set(
            ComponentInterface::class,
            function (Container $container) {
                $component = new FoobarComponent($container->get(ComponentDispatcherFactoryInterface::class));
                $component->setMVCFactory($container->get(MVCFactoryInterface::class));
                $component->setRouterFactory($container->get(RouterFactoryInterface::class));

                return $component;
            }
        );
    }  
};