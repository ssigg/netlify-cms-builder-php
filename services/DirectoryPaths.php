<?php

namespace Services;

use Interop\Container\ContainerInterface;

class DirectoryPathsFactory {
    public function __invoke(ContainerInterface $container) {
        $pathConverter = $container->get(PathConverter::Name);
        return new DirectoryPaths($pathConverter);
    }
}

interface DirectoryPathsInterface {
    function getTempDirectory();
}

class DirectoryPaths implements DirectoryPathsInterface {
    const Name = 'DirectoryPaths';

    private $pathConverter;

    public function __construct(PathConverterInterface $pathConverter) {
        $this->pathConverter = $pathConverter;
    }

    public function getTempDirectory() {
        return $this->pathConverter->convert('temp');
    }
}