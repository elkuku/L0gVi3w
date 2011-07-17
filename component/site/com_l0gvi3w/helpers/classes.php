<?php

//-- No direct access
defined('_JEXEC') || die('=;)');

/**
 * LogView log options.
 */
class LogOptions
{
    public $fileName;

    public $maxErrors;
}//class

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
    }//function

    public function getEntries()
    {
        return $this->entries;
    }//function

    public function dump()
    {
        var_dump($this->entries);
    }//function
}//class

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

        if('php' == $type)
        {
            $this->message = new ErrorLink($line);

            foreach($stack as $entry)
            {
                $this->stack[] = new ErrorLink($entry);
            }//foreach
        }
        else//
        {
            $this->message = $line;
        }
    }//function
}//class
