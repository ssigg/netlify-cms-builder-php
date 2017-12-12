<?php

namespace Services;

use Interop\Container\ContainerInterface;

class GeneratorFactory {
    public function __invoke(ContainerInterface $container) {
        $spress = new \Yosymfony\Spress\Core\Spress();
        $filesystem = new \Symfony\Component\Filesystem\Filesystem();
        $tempDirectoryPath = $container->get(DirectoryPaths::Name)->getTempDirectory();
        return new Generator($spress, $filesystem, $tempDirectoryPath);
    }
}

interface GeneratorInterface {
    function generate($branch);
}

class Generator implements GeneratorInterface {
    const Name = 'Generator';

    private $spress;
    private $filesystem;
    private $tempDirectoryPath;

    public function __construct(\Yosymfony\Spress\Core\Spress $spress, \Symfony\Component\Filesystem\Filesystem $filesystem, $tempDirectoryPath) {
        $this->spress = $spress;
        $this->filesystem = $filesystem;
        $this->tempDirectoryPath = $tempDirectoryPath;
    }

    public function generate($branch) {
        $this->spress['spress.config.site_dir'] = $this->tempDirectoryPath . '/' . $branch;
        $this->spress->parse();
        $this->filesystem->mirror($this->tempDirectoryPath . '/' . $branch . '/src/static/', $this->tempDirectoryPath . '/' . $branch . '/build/static/');
    }
}