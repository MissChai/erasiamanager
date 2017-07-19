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
	 * @param Doctrine\DBAL\Connection $db Database connection object
	 */
	public function __construct( Connection $db ) {
		$this->db = $db;
	}

	/**
	 * Grants access to the database connection object
	 *
	 * @return Doctrine\DBAL\Connection Database connection object
	 */
	protected function getDb() {
		return $this->db;
	}

	/**
	 * Builds a domain object from a database row
	 * (Must be overridden by child classes)
	 */
	protected abstract function buildDomainObject( array $row );
}