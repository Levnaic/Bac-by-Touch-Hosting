<?php

namespace BacByTouch;

use BacByTouch\ErrorHandler;

class JsonLoader
{
    private $jsonDataPath;
    private $langDataPath;
    private $allowedDirectories;

    public function __construct()
    {
        $this->jsonDataPath = realpath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "json");
        $this->langDataPath = realpath(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "json" . DIRECTORY_SEPARATOR . "languages");
        $this->allowedDirectories = [$this->jsonDataPath, $this->langDataPath];
    }

    public function loadJsonFile($fileName, $mode = 0)
    {
        $filePath = $this->resolveFilePath($fileName);

        if ($filePath && $this->isPathAllowed($filePath) && file_exists($filePath)) {
            $data = file_get_contents($filePath);
            if ($data !== false) {
                if ($mode == 0) {
                    // will return array
                    $data = json_decode($data, true);
                    return $data;
                }
                if ($mode == 1) {
                    // will retrun string
                    return $data;
                } else {
                    ErrorHandler::logError("Internal error", "bad paramethers in loadJsonFile method", __CLASS__, __LINE__);
                    Redirect::redirectToErrorPage(500);
                }
            }
            ErrorHandler::logError("I/O error", "failed to load JSON file", __CLASS__, __LINE__);
            Redirect::redirectToErrorPage(500);
        }
        ErrorHandler::logError("I/O error", "failed to get path to JSON file", __CLASS__, __LINE__);
        Redirect::redirectToErrorPage(500);
    }

    private function resolveFilePath($fileName)
    {
        foreach ($this->allowedDirectories as $dir) {
            $filePath = realpath($dir . DIRECTORY_SEPARATOR . $fileName);
            if (file_exists($filePath)) {
                return $filePath;
            }
        }
        ErrorHandler::logError("I/O error", "failed to resolve json file path", __CLASS__, __LINE__);
        Redirect::redirectToErrorPage(500);
    }

    private function isPathAllowed($filePath)
    {
        foreach ($this->allowedDirectories as $allowedDir) {
            if (strpos($filePath, $allowedDir) === 0) {
                return true;
            }
        }
        ErrorHandler::logError("I/O error", "Unallowed Json path", __CLASS__, __LINE__);
        Redirect::redirectToErrorPage(500);
    }
}
