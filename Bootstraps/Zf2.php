<?php

namespace PHPPM\Bootstraps;

use Zend\Mvc\Application;

class Zf2 implements BootstrapInterface
{
    /**
     * @var string
     */
    protected $appenv;

    /**
     * @var bool
     */
    protected $debug;

    /**
     * Instantiate the bootstrap, storing the $appenv.
     *
     * @param string $appenv
     * @param bool $debug
     */
    public function __construct($appenv, $debug)
    {
        $this->appenv = $appenv;
        $this->debug = $debug;
    }

    public function getStaticDirectory()
    {
        return 'public/';
    }

    /**
     * Create a Zend Framework MVC application.
     */
    public function getApplication()
    {
        if ($this->appenv) {
            $filename = "./config/{$this->appenv}.config.php";

        } else {
            $filename = "./config/application.config.php";
        }

        if (!file_exists($filename)) {
            throw new \RuntimeException("Configuration file {$filename} not found.");
        }

        $config = require $filename;

        $config['service_manager'] = array(
            'factories' => array(
                'ServiceListener' => 'PHPPM\Bootstraps\Zf2\Mvc\Service\ServiceListenerFactory',
            ),
        );

        return Application::init($config);
    }
}
