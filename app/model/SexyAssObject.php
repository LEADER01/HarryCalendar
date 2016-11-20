<?php
/**
 * Created by Vladimir Litovkin.
 * Description: Smart Object containing few nice-to-have and few must-have features
 * Version: 1.0
 * Date: 12.08.2016
 * Time: 4:13 am
 */

namespace App\Model;

use Nette;

class SexyAssObject extends Nette\Object
{
	/** @var Nette\Database\Context */
	protected $database; //I'm still thinking whether I want third option. TODO Settings 2v3 options?
	protected $user;

	public function __construct(Nette\Database\Context $database, Nette\Security\User $user)
	{
		$this->database = $database;
		$this->user = $user;
	}

	/**
	 * @param $needle string key
	 * @param $haystack array source
	 * @param bool $null make true if value could be null
	 * @return bool|null
	 */
	protected static function setIfGet($needle, $haystack, $null = false)
	{
		return (isset($haystack[$needle])) ? $haystack[$needle] : ($null) ? (array_key_exists($needle, $haystack) ? $haystack[$needle] : null): null;
	}

	/**
	 * @param $key string what are we looking for`
	 * @param $data where are we looking at
	 * @return bool|int|float
	 */
	protected static function is_num($key, $data) {
		return (is_numeric($newData = $data) || is_numeric($newData=self::setIfGet("year", $data))) ? $newData : false;
	}
}