<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use ErasiaManagerAPI\App\Loader;

// Accept JSON
$app->before( function ( Request $request ) {
	if ( 0 === strpos( $request->headers->get( 'Content-Type' ), 'application/json' ) ) {
		$data = json_decode( $request->getContent(), true );
		$request->request->replace( is_array( $data ) ? $data : array() );
	}
});

// CORS
$app->after( function ( Request $request, Response $response ) {
	$response->headers->set( 'Access-Control-Allow-Origin', '*' );
	$response->headers->set( 'Access-Control-Allow-Headers', 'Authorization' );
});

// Register Providers
$providerLoader = new Loader\ProviderLoader( $app );
$providerLoader->registerProvidersToContainer();

// Load Routes
$routeLoader = new Loader\RouteLoader( $app );
$routeLoader->loadRoutes();

// Catch exceptions
$app->error( function ( Exception $e, Request $request, $code ) use ( $app ) {
	$app['monolog']->addError( $e->getMessage() );
	$app['monolog']->addError( $e->getTraceAsString() );

	$error_code    = ( $e and $e->getCode() )    ? $e->getCode()    : $code;
	$error_message = ( $e and $e->getMessage() ) ? $e->getMessage() : 'We are sorry, but something went wrong.';

	return new JsonResponse( array(
		'apiVersion' => $app['api.version'],
		'errors'     => array( $error_message )
	), $error_code );
});

// Return
return $app;