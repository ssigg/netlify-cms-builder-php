<?php

namespace Services;

use Interop\Container\ContainerInterface;

class ZipArchiveFactory {
    public function __invoke(ContainerInterface $container) {
        $zip = new \splitbrain\PHPArchive\Zip();
        return new ZipArchive($zip);
    }
}

interface ZipArchiveInterface {
    function extract($zipFilePath, $destinationPath);
}

class ZipArchive implements ZipArchiveInterface {
    const Name = 'ZipArchive';

    private $zip;

    public function __construct($zip) {
        $this->zip = $zip;
    }

    public function extract($zipFilePath, $destinationPath) {
        $this->zip->open($zipFilePath);
        $this->zip->extract($destinationPath);
    }
}