<?php

namespace ErasiaManagerAPI\App\Loader;

use Silex\Application;
use Silex\Provider;

class ProviderLoader {

    /**
     * Container
     *
     * @var Silex\Application
     */
	protected $app;

    /**
     * Constructor
     *
     * @param Silex\Application $app container
     */
	public function __construct( Application $app ) {
		$this->app = $app;
	}

    /**
     * Registers providers into Silex\Application Container
     */
	public function registerProvidersToContainer() {
		$this->app->register( new Provider\MonologServiceProvider(), array(
			'monolog.logfile' => __DIR__ . '/../../../storage/logs/' . date('Y-m-d_') . 'errors.log',
			'monolog.level'   => $this->app['log.level'],
			'monolog.name'    => 'app'
		));

		$this->app->register( new Provider\DoctrineServiceProvider(), array(
			'db.options' => $this->app['db.options']
		));
	}
}