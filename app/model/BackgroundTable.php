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
		$year = date("y"); //TODO replace with value which makes sense
		$ret = "<table id='backgroundTable'>";
		for ($i = 1; $i <= 12; $i++) {
			$ret .= "<tr>";
			for ($j = 1; $j <= cal_days_in_month(CAL_GREGORIAN, $i, $year); $j++) {
				$ret .= "<td style='background-color: rgba(".rand(0, 255).", ".rand(0, 255).", ".rand(0, 255).", ".(rand(5, 10) / 10).");'>&nbsp $j</td>";
			}
			$ret .= "</tr>";
		}
		$ret .= "</table>";
		return $ret;
	}

}
