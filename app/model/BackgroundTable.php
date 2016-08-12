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

private static $colors = array("red", "black", "blue");
	/** @var Nette\Database\Context */
	private $database; //I'm still thinking whether I want third option. TODO Settings 2v3 options?

	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}

	/**
	 * @param string $type
	 * @return string
	 */
	public static function createTable($type = "empty", $data = null) {
		switch ($type) {
			case "empty":
				$year = date("y"); //TODO replace with value which makes sense
				$ret = "<table id='backgroundTable'>";
				for ($i = 1; $i <= 12; $i++) {
					$ret .= "<tr>";
					for ($j = 1; $j <= cal_days_in_month(CAL_GREGORIAN, $i, $year); $j++) {
						$ret .= "<td class='".self::$colors[rand(0, 2)]."-day'>&nbsp</td>";
					}
					$ret .= "</tr>";
				}
				$ret .= "</table>";
				break;
			case "previousYears":
				//TODO think up some fancy ass validation for this kind of stuff
				if (is_numeric($data) || (is_array($data) && isset($data["year"]))) {
					$ret = "<table id='previousYearsTable'><tr>";
					for ($i = $data; $i < 0+date("Y"); $i++) {
						$ret .= "<td>$i</td>";
					}
					$ret .= "</tr></table>";
				}
				else {
					throw new Nette\InvalidArgumentException("Data[...] should contain Birth year");
				}
				break;
			case "":
				break;
			default:
				break;
		}
		return $ret;
	}

}
