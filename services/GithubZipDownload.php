<?php

namespace Services;

use Interop\Container\ContainerInterface;

class GithubZipDownloadFactory {
    public function __invoke(ContainerInterface $container) {
        $httpClient = $container->get(HttpClient::Name);
        $zipArchive = $container->get(ZipArchive::Name);
        $tempDirectoryPath = $container->get(DirectoryPaths::Name)->getTempDirectory();
        $githubZipDownload = new GithubZipdownload($httpClient, $zipArchive, $tempDirectoryPath);
        return $githubZipDownload;
    }
}

interface GithubZipDownloadInterface {
    function download($repositoryUrl, $branch);
}

class GithubZipDownload implements GithubZipDownloadInterface {
    const Name = 'GithubZipDownload';

    private $httpClient;
    private $zipArchive;
    private $tempDirectoryPath;

    public function __construct(HttpClientInterface $httpClient, ZipArchiveInterface $zipArchive, $tempDirectoryPath) {
        $this->httpClient = $httpClient;
        $this->zipArchive = $zipArchive;
        $this->tempDirectoryPath = $tempDirectoryPath;
    }

    public function download($repositoryUrl, $branch) {
        $url = $repositoryUrl . '/archive/' . $branch . '.zip';
        $zipFilePath = $this->tempDirectoryPath . '/' . $branch . '.zip';
        $this->httpClient->download($url, $zipFilePath);
        $this->zipArchive->extract($zipFilePath, $this->tempDirectoryPath . '/' . $branch);
    }
}