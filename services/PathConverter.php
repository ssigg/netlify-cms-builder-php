<?php

namespace Services;

use Interop\Container\ContainerInterface;

class PathConverterFactory {
    public function __invoke(ContainerInterface $container) {
        return new PathConverter($container->get('root'));
    }
}

interface PathConverterInterface {
    function convert($relativePath);
}

class PathConverter implements PathConverterInterface {  
    const Name = 'PathConverter';
      
    private $root;

    public function __construct($root) {
        $this->root = $root;
    }

    public function convert($relativePath) {
        return $this->root . '/' . $relativePath;
    }
}