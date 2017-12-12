<?php

namespace Services;

require 'DirectoryPaths.php';
require 'PathConverter.php';
require 'HttpClient.php';
require 'ZipArchive.php';
require 'GithubZipDownload.php';
require 'Generator.php';

use Interop\Container\ContainerInterface;

class AppFactory {
    public static function createForProduction($rootDirectoryPath) {
        $app = new \Slim\App([ 'root' => $rootDirectoryPath ]);
        $container = $app->getContainer();
        self::configureContainerForProduction($container);
        return $app;
    }

    public static function configureContainerForProduction(ContainerInterface $container) {
        $f = new AppFactory($container);
        
        $f->addService(DirectoryPaths::Name, DirectoryPathsFactory::class);
        $f->addService(PathConverter::Name, PathConverterFactory::class);
        
        $f->addService(HttpClient::Name, HttpClientFactory::class);
        $f->addService(ZipArchive::Name, ZipArchiveFactory::class);
        $f->addService(GithubZipDownload::Name, GithubZipDownloadFactory::class);
        
        $f->addService(Generator::Name, GeneratorFactory::class);
    }

    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function addService($name, $serviceFactory) {
        $this->container[$name] = $this->container->factory(new $serviceFactory());
    }
}