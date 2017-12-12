<?php

namespace Services;

use Interop\Container\ContainerInterface;

class HttpClientFactory {
    public function __invoke(ContainerInterface $container) {
        $client = new \GuzzleHttp\Client();
        return new HttpClient($client);
    }
}

interface HttpClientInterface {
    function download($url, $destinationPath);
}

class HttpClient implements HttpClientInterface {
    const Name = 'HttpClient';
    
    private $client;

    public function __construct($client) {
        $this->client = $client;
    }

    public function download($url, $destinationPath) {
        $this->client->request('GET', $url, [ 'sink' =>  $destinationPath ]);
    }
}