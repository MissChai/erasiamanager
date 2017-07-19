<?php

namespace ErasiaManagerAPI\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use ErasiaManagerAPI\Entity\Character;
use ErasiaManagerAPI\Repository\CharacterRepository;
use ErasiaManagerAPI\Form\Type\CharacterType;

class CharacterController extends DefaultController {

	/**
	 * Constructor
	 *
	 * @param Silex\Application $app Silex application
	 * @param ErasiaManagerAPI\Repository\CharacterRepository $repository repository
	 */
	public function __construct( Application $app, CharacterRepository $repository ) {
		parent::__construct( $app, $repository );
	}

	/**
	 * Returns a JSON response with a list of all characters, sorted by name
	 *
	 * @return JsonResponse List of all characters
	 */
	public function catalogueAction() {
		return $this->returnJsonResponse( $this->getRepository()->findAll() );
	}

	/**
	 * Returns a JSON response with information about a character
	 *
	 * @param int $char_id Character identifier
	 * @return JsonResponse Information about the character
	 */
	public function getAction( int $char_id ) {
		return $this->returnJsonResponse( $this->getRepository()->findById( $char_id ) );
	}

	/**
	 * Character creation
	 *
	 * @param Symfony\Component\HttpFoundation\Request $request Incoming request
	 * @return JsonResponse Information about the character
	 * @throws InvalidArgumentException if the form is not valid
	 */
	public function createAction( Request $request ) {
		$character = new Character();

		$character_form = $this->getApp()['form.factory']->create( CharacterType::class, $character );
		$character_form->submit( $this->getDataFromRequest( $request ) );

		if ( !$character_form->isValid() ) {
			throw new \InvalidArgumentException( $this->convertFormErrorsToString( $character_form ), 400 );
		}
		return $this->returnJsonResponse( $this->getRepository()->save( $character ), 201 );
	}

	/**
	 * Character update
	 *
	 * @param int $char_id Character identifier
	 * @param Symfony\Component\HttpFoundation\Request $request Incoming request
	 * @return JsonResponse Information about the character
	 * @throws InvalidArgumentException if the form is not valid
	 */
	public function updateAction( int $char_id, Request $request ) {	
		$clearMissing = ( $request->getMethod() == 'PUT' ) ? true : false;
		$character    = $this->getRepository()->findById( $char_id );

		$character_form = $this->getApp()['form.factory']->create( CharacterType::class, $character );
		$character_form->submit( $this->getDataFromRequest( $request ), $clearMissing );

		if ( !$character_form->isValid() ) {
			throw new \InvalidArgumentException( $this->convertFormErrorsToString( $character_form ), 400 );
		}
		return $this->returnJsonResponse( $this->getRepository()->save( $character ), 200 );
	}

	/**
	 * Character delete
	 *
	 * @param int $char_id Character identifier
	 * @param Symfony\Component\HttpFoundation\Request $request Incoming request
	 * @return JsonResponse
	 */
	public function deleteAction( int $char_id ) {
		$this->getRepository()->delete( $char_id );
		return $this->returnJsonResponse( null, 200 );
	}
}