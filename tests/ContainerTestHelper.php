<?php

use Interop\Container\ContainerInterface;

class ContainerTestHelper {
    public static function createWrappedProductionContainer() {
        $container = new \Slim\Container;
        $container['root'] = __DIR__ . '/data';
        Services\AppFactory::configureContainerForProduction($container);
        return new WrappedContainer($container);
    }
}

class WrappedContainer {
    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function andReplaceServiceWith($name, $service) {
        $this->container[$name] = $service;
        return $this;
    }

    public function getContainer() {
        return $this->container;
    }
}