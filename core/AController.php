<?php

namespace Core;



abstract class AController
{


    protected $redirectUrl;

    protected $flashMsgs = [];

    protected $logPath = __DIR__ . '/../logs/logs.txt';

    /**
     * @param string $content
     * @param array $data
     */
    public function render($content, $data = [])
    {

        if (empty($data['layout'])) $data['layout'] = 'main';

        $user = Auth::user();
        
        require_once ('../app/views/layouts/' . $data['layout'] . '.php');

        $this->clearFlashCache();
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

    public function flashMsg($name, $msg)
    {
        $_SESSION[$name] = $msg;
        $_SESSION[$name . '_flash'] = $msg;

    }

    public function clearFlashCache()
    {
        foreach ($_SESSION as $name => $value) {
            if (isset($_SESSION[$name . '_flash'])){
                 unset($_SESSION[$name]);
                 unset($_SESSION[$name . '_flash']);
            }
           
        }
    }

    public function redirect($url, $data = false)
    {
        if ($data) {
            foreach ($_POST as $key => $value ) {
                $this->flashMsg($key, $value );
            }
        }
        header('Location: ' . $url);
    }

}