<?php

namespace App\Model;

use Nette;


/**
 * Users management.
 */
class BackgroundTable extends SexyAssObject
{
//	const
//		TABLE_NAME = 'users',
//		COLUMN_ID = 'idUser',
//		COLUMN_NAME = 'email',
//		COLUMN_PASSWORD_HASH = 'pass',
//		COLUMN_ROLE = 'role';

	private $colors = array("red", "black", "blue", "grey");
	private $today = array();

	/**
	 * @param string $type
	 * @return string
	 */
	public function createTable($type = "empty", $data = null)
	{
		switch ($type) {
			case "currentYear":
				$year = date("y"); //TODO replace with value which makes sense
				(isset($data["showToday"])) ? $today = array("y" => date("y"), "m" => date("m"), "d" => date("d")) : null;
				$ret = "<table id='backgroundTable'>";
				for ($i = 1; $i <= 12; $i++) {
					$ret .= "<tr>";
					$todaysMonth = (isset($today)) ? ($i == $today["m"]) ? true : null : null;
					for ($j = 1; $j <= cal_days_in_month(CAL_GREGORIAN, $i, $year); $j++) {
						$color = ($data["random"]) ? $this->colors[rand(0, 2)] : $this->getDayColor($j, $i, $year);
						$ret .= "<td class='".((isset($todaysMonth)) ? ($j == $today["d"]) ? "today-day " : null : null).$color."-day c-allign'>$j</td>";
					}
					$ret .= "</tr>";
				}
				$ret .= "</table>";
				break;
			case "previousYears":
				if ($newData = self::is_num("year", $data)) {
					$ret = "<table id='previousYearsTable'><tr>";
					for ($i = $newData; $i < 0+date("Y"); $i++) {
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

	private function getDay($d, $m, $y)
	{
		$day = $this->database->table("day")->where(array(
			"day" => $d,
			"month" => $m,
			"year" => $y,
		));
		return ($day->count()) ? $day->fetch() : false;
	}

	private function getDayColor($d, $m, $y)
	{
		$day = $this->getDay($d, $m, $y); //TODO get day through $this and make if blow with this return
		if ($day) {
			$uDay = $this->database->table("userdaterating")->where(array(
				"idUser" => $this->user->id,
				"idDay" => $day->id
			));
			if ($uDay->count()) {
				return $this->database->table("daterating")->get($uDay->idDateRating)->color;
			} else return $this->colors[3];
		} else return $this->colors[3];
	}

	private static function isDayStored()
	{

	}

}
