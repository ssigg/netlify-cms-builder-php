<?php

class DirectoryAssertHelper {
    private $testCase;

    public function __construct(\PHPUnit_Framework_TestCase $testCase) {
        $this->testCase = $testCase;
    }

    public function assertEquals($expectedDirectoryPath, $actualDirectoryPath) {
        $expectedItems = scandir($expectedDirectoryPath);
        $actualItems = scandir($actualDirectoryPath);
        $this->testCase->assertEquals($expectedItems, $actualItems);
        foreach ($expectedItems as $expectedItem) {
            if ($expectedItem != '.' && $expectedItem != '..' && is_dir($expectedDirectoryPath . '/' . $expectedItem)) {
                $this->assertEquals($expectedDirectoryPath . '/' . $expectedItem, $actualDirectoryPath . '/' . $expectedItem);
            }
        }
    }
}