<?php

class ActionsTestHelper {
    public static function getPostRequest($path, $payload) {
        $environment = \Slim\Http\Environment::mock([
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI' => $path
        ]);
        $request = \Slim\Http\Request::createFromEnvironment($environment);
        $request = $request->withParsedBody($payload);
        return $request;
    }
}