<?php

namespace ErasiaManagerAPI\Repository;

use ErasiaManagerAPI\Entity\Character;

class CharacterRepository extends DefaultRepository {

	/**
	 * Return a list of all characters, sorted by name
	 *
	 * @return array A list of ErasiaManagerAPI\Entity\Character
	 */
	public function findAll(): array {
		$sql = "
			SELECT *
			FROM t_character
			ORDER BY t_character.char_name
		";
		$result = $this->getDb()->fetchAll( $sql );

		$characters = array();
		foreach ( $result as $row ) {
			array_push( $characters, $this->buildDomainObject( $row ) );
		}
		return $characters;
	}

	/**
	 * Returns a character matching the supplied id
	 *
	 * @param int $char_id The character id
 	 * @return ErasiaManagerAPI\Entity\Character|String if an error occured
	 */
    public function findById( int $char_id ): Character {
		$sql = "
			SELECT *
			FROM t_character
			WHERE t_character.char_id = ?
		";
		$row = $this->getDb()->fetchAssoc( $sql, array( $char_id ) );

		if ( $row ) {
			return $this->buildDomainObject( $row );
		}
		else {
			throw new \InvalidArgumentException( sprintf( 'Character not found: the identifier "%s" does not match any known character.', $char_id ), 404 );
		}
    }

	/**
	 * Saves a character into the database
	 *
	 * @param ErasiaManagerAPI\Entity\Character $character The character to save
	 * @return ErasiaManagerAPI\Entity\Character The saved character
	 */
    function save( Character $character ): Character {
		// Data
		$character_data = array(
			'char_name'   => htmlspecialchars( $character->getName() ),
			'char_points' => htmlspecialchars( $character->getPoints() ),
			'char_color'  => htmlspecialchars( $character->getColor() ),
		);

		// Update
		if ( $character->getId() ) {
			$this->getDb()->update( 't_character', $character_data, array( 'char_id' => $character->getId() ) );
			return $this->findById( $character->getId() );
		}

		// Insert
		else {
			$this->getDb()->insert( 't_character', $character_data );
			return $this->findById( $this->getDb()->lastInsertId() );
		}
    }

	/**
	 * Removes a character from the database
	 *
	 * @param int $char_id The character id
	 */
    function delete( int $char_id ) {
		$this->getDb()->delete( 't_character', array( 'char_id' => $this->findById( $char_id )->getId() ) );
    }

	/**
	 * Creates a ErasiaManagerAPI\Entity\Character based on a database row
	 *
	 * @param array $row The database row containing the data
	 * @return ErasiaManagerAPI\Entity\Character
	 */
	protected function buildDomainObject( array $row ) {
		$character = new Character();

		$character->setId( $row['char_id'] );
		$character->setName( $row['char_name'] );
		$character->setPoints( $row['char_points'] );
		$character->setColor( $row['char_color'] );

		return $character;
	}
}