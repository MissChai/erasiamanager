<?php

namespace ErasiaManagerAPI\Entity;

use JsonSerializable;

class Character implements JsonSerializable {

	/**
	 * Character id
	 *
	 * @var integer
	 */
	private $id;

	/**
	 * Character name
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Character points
	 *
	 * @var integer
	 */
	private $points;

	/**
	 * Character color
	 *
	 * @var string
	 */
	private $color;

	public function getId() {
		return $this->id;
	}

	public function setId( $id ) {
		$this->id = $id;
	}

	public function getName() {
		return $this->name;
	}

	public function setName( $name ) {
		$this->name = $name;
	}

	public function getPoints() {
		return $this->points;
	}

	public function setPoints( $points ) {
		$this->points = $points;
	}

	public function getColor() {
		return $this->color;
	}

	public function setColor( $color ) {
		$this->color = $color;
	}

    public function jsonSerialize() {
        return [
			'id'     => $this->id,
			'name'   => $this->name,
			'points' => $this->points,
			'color'  => $this->color
		];
    }
}