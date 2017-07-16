<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ErasiaManagerAPI\App\Loader;

// Process Exceptions
ErrorHandler::register();
ExceptionHandler::register( $app['debug'] );

$app->error( function ( Exception $e, Request $request ) use ( $app ) {
	$error_domain  = 'App';
	$error_type    = 'Exception';
	$error_message = 'We are sorry, but it seems something went wrong.';
	$error_code    = 500;

	if ( $e ) {
		$error_domain  = preg_replace( '/.*\/(\w*).php/', '${1}', $e->getFile() );
		$error_type    = preg_replace( '/.*\\\(\w*)/',    '${1}', get_class( $e ) );
		$error_message = ( $e->getMessage() ) ? $e->getMessage() : $error_message;

		$error_code = ( $e->getCode() ) ? $e->getCode() : $error_code;
		if ( preg_match( '/^No route found for/', $error_message ) ) {
			$error_code = 404;
		}

		$app['monolog']->addError( $error_message );
		$app['monolog']->addError( $e->getTraceAsString() );
	}
	else {
		$app['monolog']->addError( $error_message );
	}

	return $app->json( array(
		'apiVersion' => $app['api.version'],
		'errors'     => array(
			'domain'  => $error_domain,
			'type'    => $error_type,
			'message' => $error_message,
			'code'    => $error_code,
		)
	), $error_code );
});

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

// Return
return $app;