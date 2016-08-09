<?php

namespace App\Model;

use Nette;


/**
 * Users management.
 */
class BackgroundTable extends Nette\Object
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

	/**
	 * @param string $type
	 * @return string
	 */
	public static function createTable($type = "empty") {
		$ret = "<table id='backgroundTable'>";
		for ($i = 0; $i < 6; $i++) {
			$ret .= "<tr>";
			for ($j = 0; $j < 61; $j++) {
				$ret .= "<td>.</td>";
			}
			$ret .= "</tr>";
		}
		$ret .= "</table>";
		return $ret;
	}
}
