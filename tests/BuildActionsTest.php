<?php

class BuildActionsTest extends \PHPUnit_Framework_TestCase {
    private $inputDirectoryPath = __DIR__ . '/data/input/';
    private $tempDirectoryPath = __DIR__ . '/data/temp/';
    private $actualDirectoryPath = __DIR__ . '/data/actual/';
    private $expectedDirectoryPath = __DIR__ . '/data/expected/';

    private $directoryAssertHelper;
    private $fs;

    protected function setUp() {
        $this->directoryAssertHelper = new DirectoryAssertHelper($this);
        $this->fs = new \Symfony\Component\Filesystem\Filesystem();
    }
    
    protected function tearDown() {
        $this->fs->remove($this->tempDirectoryPath . '/master.zip');
        $this->fs->remove($this->tempDirectoryPath . '/master/');
        $this->fs->remove($this->actualDirectoryPath . '/example-site/');
    }

    public function testBuildAllAction() {
        $httpClientMock = $this->getMockBuilder(Services\HttpClientInterface::class)
            ->setMethods(['download'])
            ->getMock();

        $container = ContainerTestHelper::createWrappedProductionContainer()
            ->andReplaceServiceWith(Services\HttpClient::Name, $httpClientMock)
            ->getContainer();

        $action = new Actions\BuildAllAction($container);
        $payload = [ 'repository' => [ 'url' => 'http://example.com/user/repo' ] ];
        $request = ActionsTestHelper::getPostRequest('/build', $payload);
        $initialResponse = new \Slim\Http\Response;

        $httpClientMock
            ->expects($this->once())
            ->method('download')
            ->will($this->returnCallback([$this, 'copyZipToTemp']));

        $response = $action($request, $initialResponse, []);

        $this->fs->mirror($this->tempDirectoryPath . '/master/build/', $this->actualDirectoryPath . '/example-site/');
        $this->directoryAssertHelper->assertEquals($this->expectedDirectoryPath . '/example-site/', $this->actualDirectoryPath . '/example-site/');
    }

    public function copyZipToTemp() {
        $this->fs->copy($this->inputDirectoryPath . '/example-site.zip', $this->tempDirectoryPath . '/master.zip');
    }
}