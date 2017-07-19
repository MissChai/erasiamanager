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
	private $app;

	/**
	 * Constructor
	 *
	 * @param Silex\Application $app container
	 */
	public function __construct( Application $app ) {
		$this->app = $app;
	}

	/**
	 * Returns the Silex container
	 *
	 * @return Silex\Application Silex application
	 */
	protected function getApp() {
		return $this->app;
	}

	/**
	 * Registers providers into Silex\Application Container
	 */
	public function registerProvidersToContainer() {
		$this->app->register( new Provider\MonologServiceProvider(), array(
			'monolog.logfile' => $this->app['path.root'] . 'storage/logs/' . date('Y-m-d_') . 'errors.log',
			'monolog.level'   => $this->app['log.level'],
			'monolog.name'    => 'app'
		));

		$this->app->register( new Provider\DoctrineServiceProvider(), array(
			'db.options' => $this->app['db.options']
		));

		$this->app->register( new Provider\ServiceControllerServiceProvider() );
		$this->app->register( new Provider\FormServiceProvider() );
		$this->app->register( new Provider\ValidatorServiceProvider() );
	}
}