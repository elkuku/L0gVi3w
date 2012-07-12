<?php
/**
 * @version    SVN: $Id$
 * @package    L0gVi3w
 * @subpackage Helpers
 * @author     Nikolai Plath {@link http://nik-it.de}
 * @author     Created on 17-Jul-2011
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

/**
 * LogView log options.
 */
class LogOptions
{
	public $fileName;

	public $maxErrors;
}

//class

/**
 * LogView log class.
 */
class LogViewLog
{
	public $mTime = 0;

	public $size = 0;

	private $entries = array();

	public function addItem(ErrorItem $item)
	{
		array_unshift($this->entries, $item);
	}

	public function getEntries()
	{
		return $this->entries;
	}

	public function dump()
	{
		var_dump($this->entries);
	}
}

/**
 * LogView error item class.
 */
class ErrorItem
{
	public $message = '';

	public $stack = array();

	public $id = 0;

	public function __construct($id, $line, $stack = array(), $type = '')
	{
		$this->id = $id;

		if ('php' == $type)
		{
			$this->message = new ErrorLink($line);

			foreach ($stack as $entry)
			{
				$this->stack[] = new ErrorLink($entry);
			}
		}
		else
		{
			$this->message = $line;
		}
	}
}
