<?php

namespace ErasiaManagerAPI\Repository;

use Doctrine\DBAL\Connection;

abstract class DefaultRepository {

	/**
	 * Database connection
	 *
	 * @var Doctrine\DBAL\Connection
	 */
	private $db;

	/**
	 * Constructor
	 *
	 * @param Doctrine\DBAL\Connection $db The database connection object
	 */
	public function __construct( Connection $db ) {
		$this->db = $db;
	}

	/**
	 * Grants access to the database connection object
	 *
	 * @return Doctrine\DBAL\Connection The database connection object
	 */
	protected function getDb() {
		return $this->db;
	}

	/**
	 * Builds a domain object from a DB row
	 * (Must be overridden by child classes)
	 */
	protected abstract function buildDomainObject( $row );
}