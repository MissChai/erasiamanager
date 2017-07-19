<?php

namespace ErasiaManagerAPI\App\Loader;

use Silex\Application;

use ErasiaManagerAPI\Repository;
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
	 * @param Silex\Application $app Silex container
	 */
	public function __construct( Application $app ) {
		$this->app = $app;
	}

	/**
	 * Returns the Silex container
	 *
	 * @return Silex\Application Silex container
	 */
	protected function getApp() {
		return $this->app;
	}

	/**
	 * Load routes
	 */
	public function loadRoutes() {
		$this->bindRepositoriesToContainer();
		$this->bindControllersToContainer();
		$this->bindRoutesToControllers();
	}

	/**
	 * Binds repositories into Silex\Application container
	 */
	public function bindRepositoriesToContainer() {
		$this->app['character.repository'] = function() {
			return new Repository\CharacterRepository( $this->app['db'] );
		};
	}

	/**
	 * Binds controllers into Silex\Application container
	 */
	private function bindControllersToContainer() {
		$this->app['character.controller'] = function() {
			return new Controller\CharacterController( $this->app, $this->app['character.repository'] );
		};
	}

	/**
	 * Binds routes to controllers
	 */
	public function bindRoutesToControllers() {
		if ( $this->app['debug'] ) {
			$this->app->get( '/', function () { return phpinfo(); } );
		}

		$api = $this->app['controllers_factory'];

		// Character
		$api->get(    '/characters',           'character.controller:catalogueAction' );
		$api->get(    '/characters/{char_id}', 'character.controller:getAction' )->assert( 'char_id', '\d+' );
		$api->post(   '/characters',           'character.controller:createAction' );
		$api->put(    '/characters/{char_id}', 'character.controller:updateAction' )->assert( 'char_id', '\d+' );
		$api->patch(  '/characters/{char_id}', 'character.controller:updateAction' )->assert( 'char_id', '\d+' );
		$api->delete( '/characters/{char_id}', 'character.controller:deleteAction' )->assert( 'char_id', '\d+' );

		$this->app->mount( $this->app['api.endpoint'] . '/' . $this->app['api.version'], $api );
	}
}