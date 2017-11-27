<?php

namespace Core;

abstract class AController
{

    protected $logPath = __DIR__ . '/../logs/logs.txt';

    /**
     * @param string $content
     * @param array $data
     */
    public function render($content, $data = [])
    {
        require_once ('../app/views/layouts/main.php');
    }

    /**
     * @param $logString
     */
    public function logs($logString)
    {
        if (!file_exists($this->logPath)) {
            file_put_contents($this->logPath, '');
        }
        $logs = file_get_contents($this->logPath);
        $logs .= $logString;
        file_put_contents($this->logPath, $logs);
    }

}