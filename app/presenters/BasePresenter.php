<?php

namespace App\Presenters;

use Nette;
use App\Model;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	/** @var \Nette\Database\Context */
	public $database;
	private $todayDayOfTheYear;
	protected $log;


	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
		$this->log = new Model\Log($database);
		$cache = new \Nette\Caching\Cache(new Nette\Caching\Storages\DevNullStorage());
		$cache->clean(array($cache::ALL => TRUE));
	}
	
	/**
	 * @return mixed
	 */
	public function getTodayDayOfTheYear()
	{		
		return date("z")+1;
	}
	
	protected function logCheck ($event, $params) {
		if ($this->log->check($event, $params) == 0)
			$this->log->add($event, $params);
		else {
			echo "This action has been registered earlier";
			die();
		}
	}
}
