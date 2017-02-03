<?php
/**
 * Created by PhpStorm.
 * User: ZooxPC
 * Date: 2/2/2017
 * Time: 6:38 PM
 */

namespace macro\doc;


class Profile {

	private $first = NULL;

	public function __construct($first) {
		$this->first = $first;
	}

	function __toString() : string {
		return $this->first;
	}
}