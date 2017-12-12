<?php

namespace Actions;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class BuildAllAction {
    private $githubZipDownload;
    private $generator;

    public function __construct(ContainerInterface $container) {
        $this->githubZipDownload = $container->get(\Services\GithubZipDownload::Name);
        $this->generator = $container->get(\Services\Generator::Name);
    }

    public function __invoke(Request $request, Response $response, $args = []) {
        $payload = $request->getParsedBody();

        // Download and extract zip from Github
        $repositoryUrl = $payload['repository']['url'];
        $branch = 'master';
        $this->githubZipDownload->download($repositoryUrl, $branch);

        // Use generator to generate the site
        $this->generator->generate($branch);

        return $response->withStatus(201);
    }
}