<?php

namespace ErasiaManagerAPI\App\Loader;

use Silex\Application;

use ErasiaManagerAPI\Controller;

class RouteLoader {

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
     * Binds routes to controllers
     */
	public function loadRoutes() {
		$this->bindRepositoriesToContainer();
		$this->bindControllersToContainer();
		$this->bindRoutesToControllers();
	}

    /**
     * Binds repositories into Silex\Application Container
     */
	public function bindRepositoriesToContainer() {

	}

    /**
     * Binds controllers into Silex\Application Container
     */
	private function bindControllersToContainer() {

	}

    /**
     * Binds routes to controllers
     */
	public function bindRoutesToControllers() {
		$this->app->get( '/', function () { return phpinfo(); } );
	}
}