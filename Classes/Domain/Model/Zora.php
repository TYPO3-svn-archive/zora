<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package zora
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Zora_Domain_Model_Zora extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * Title of the query
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * Last update (timestamp)
	 *
	 * @var DateTime
	 */
	protected $lastUpdate;

	/**
	 * Query Type
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $zoraQueryType;

	/**
	 * Holds flexForm
	 *
	 * @var string
	 */
	protected $flexForm;

	/**
	 * Holds converted html
	 *
	 * @var string
	 */
	protected $serialized;

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the serialized
	 *
	 * @return string serialized
	 */
	public function getSerialized() {
		return $this->serialized;
	}

	/**
	 * Sets the serialized
	 *
	 * @param string $serialized
	 * @return string serialized
	 */
	public function setSerialized($serialized) {
		$this->serialized = $serialized;
	}

	/**
	 * Returns the flexForm
	 *
	 * @return string $flexForm
	 */
	public function getFlexForm() {
		return $this->flexForm;
	}

	/**
	 * Sets the flexForm
	 *
	 * @param string $flexForm
	 * @return void
	 */
	public function setFlexForm($flexForm) {
		$this->flexForm = $flexForm;
	}

	/**
	 * Returns the zoraQueryType
	 *
	 * @return integer $zoraQueryType
	 */
	public function getZoraQueryType() {
		return $this->zoraQueryType;
	}

	/**
	 * Sets the zoraQueryType
	 *
	 * @param integer $zoraQueryType
	 * @return void
	 */
	public function setZoraQueryType($zoraQueryType) {
		$this->zoraQueryType = $zoraQueryType;
	}

	/**
	 * Returns the lastUpdate
	 *
	 * @return DateTime lastUpdate
	 */
	public function getLastUpdate() {
		return $this->lastUpdate;
	}

	/**
	 * Sets the lastUpdate
	 *
	 * @param DateTime $lastUpdate
	 * @return DateTime lastUpdate
	 */
	public function setLastUpdate($lastUpdate) {
		$this->lastUpdate = $lastUpdate;
	}

}
?>