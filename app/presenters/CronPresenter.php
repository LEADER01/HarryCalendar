<?php

namespace App\Presenters;

use Nette;
use App\Model;


class CronPresenter extends BasePresenter
{

	public function actionAskAboutDay($hour)
	{
		if (!($hour >= date("H")-1 && $hour <= date("H")+1)) {
			exit("You little mother hacker");
		}

		$this->logCheck("ask_about_day", array("hour" => $hour, "day" => date("z"), "year" => date("Y")));

		$usersIds = $this->database->table("userSettings")->select("idUser")->where(array("name" => "sending_hour", "value" => $hour));
		$checkedUsers = $this->database->table("usersDateRating")->select("idUser")->where(
			array(
				"idUser" => $usersIds,
				"idDay" => $this->getTodayDayOfTheYear(),
				"idDateRating" => null
			)
		);
		$usersData = $this->database->table("user")->where("idUser", $checkedUsers)->fetchAll();
		foreach ($usersData as $u) {
			$u->email; $u->name; //and generate url.
			//TODO send email by template with variables from $u
		}

	}

	public function actionGenerateNextDay() {
		$this->logCheck("generate_new_day", array("day" => date("z"), "year" => date("Y")));
		$users = $this->database->table("user")->select("idUser")->fetchAll();
		$idDay = $this->database->table("day")->insert(array(
			"day" => date("j"),
			"month" => date("n"),
			"year" => date("Y"),
			"dayOfTheYear" => date("z"),
		))->idDay;
		$res = array();
		foreach ($users as $u) {
			$res[] = array(
				"idDay" => $idDay,
				"idUser" => $u->idUser,
			);
		}
		$this->database->table("usersdaterating")->insert($res);
	}

}
