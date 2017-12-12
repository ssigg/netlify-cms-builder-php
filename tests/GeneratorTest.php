<?php

class GeneratorTest extends \PHPUnit_Framework_TestCase {
    private $siteName = 'example-site';
    private $inputDirectoryPath = __DIR__ . '/data/input/example-site/';
    private $tempDirectoryPath = __DIR__ . '/data/temp/example-site/';
    private $actualDirectoryPath = __DIR__ . '/data/actual/example-site/';
    private $expectedDirectoryPath = __DIR__ . '/data/expected/example-site/';

    private $directoryAssertHelper;
    private $fs;

    protected function setUp() {
        $this->directoryAssertHelper = new DirectoryAssertHelper($this);
        $this->fs = new \Symfony\Component\Filesystem\Filesystem();
        $this->fs->mirror($this->inputDirectoryPath, $this->tempDirectoryPath);
    }

    protected function tearDown() {
        $this->fs->remove($this->tempDirectoryPath);
        $this->fs->remove($this->actualDirectoryPath);
    }

    public function testGenerateExampleSiteAction() {
        $container = ContainerTestHelper::createWrappedProductionContainer()->getContainer();
        
        $generator = $container->get(Services\Generator::Name);
        $generator->generate($this->siteName);

        $this->fs->mirror($this->tempDirectoryPath . '/build/', $this->actualDirectoryPath);
        $this->directoryAssertHelper->assertEquals($this->expectedDirectoryPath, $this->actualDirectoryPath);
    }
}