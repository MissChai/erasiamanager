<?php

namespace ErasiaManagerAPI\Controller;

use Silex\Application;

use ErasiaManagerAPI\Repository\DefaultRepository;

abstract class DefaultController {

    /**
     * Container
     *
     * @var Silex\Application
     */
	private $app;

    /**
     * Repository
     *
     * @var ErasiaManagerAPI\Service\DefaultRepository
     */
	private $repository;

	/**
	 * Constructor
	 *
	 * @param Silex\Application $app Silex application
	 * @param ErasiaManagerAPI\Repository\DefaultRepository $repository Repository
	 */
	public function __construct( Application $app, DefaultRepository $repository ) {
		$this->app        = $app;
		$this->repository = $repository;
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
	 * Returns the repository
	 *
	 * @return \ErasiaManagerAPI\Repository\DefaultRepository repository
	 */
	protected function getRepository() {
		return $this->repository;
	}

    /**
     * Retrieves data from a Request
     *
     * @param Request $request Incoming request
	 * @return The information decoded
     */
	public function getDataFromRequest( Request $request ) {
		return json_decode( $request->getContent(), true );
	}

	/**
	 * Returns a JsonResponse when a error occured
	 *
	 * @param Array|Entity $data An array of entities
	 * @param int $code The return code
	 * @return JsonResponse Information about the error that occured
	 */
	protected function returnJsonResponse( $data, int $code = 200 ) {
		$json = array();

		$json['apiVersion'] = $this->app['api.version'];

		if ( $data ) {
			if ( !is_array( $data ) ) {
				$json['data'] = array( $data );
			}
			else {
				$json['data'] = $data;
			}
		}

		return $this->app->json( $json, $code );
	}
}