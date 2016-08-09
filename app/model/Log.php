<?php

namespace App\Model;

use Nette;


/**
 * Users management.
 */
class Log extends Nette\Object
{
//	const
//		TABLE_NAME = 'users',
//		COLUMN_ID = 'idUser',
//		COLUMN_NAME = 'email',
//		COLUMN_PASSWORD_HASH = 'pass',
//		COLUMN_ROLE = 'role';

	/** @var Nette\Database\Context */
	private $database;


	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}

	public function add($event, $params = null) {
		if ($params)
			$params = http_build_query($params);
		$this->database->table("log")->insert(array("event" => $event, "additional_params" => $params));
		return true;
	}

	public function check($event, $params = null) {
		if ($params) {
			$params = http_build_query($params);
		}
			return ($count = $this->database->table("log")->where(
				array("event"=>$event, "additional_params" => $params)
			)->count() > 0) ? $count : 0;
	}
}
