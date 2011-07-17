<?php
/**
 * @version SVN: $Id$
 * @package    Logview
 * @subpackage Helpers
 * @author     Nikolai Plath (elkuku) {@link http://www.nik-it.de NiK-IT.de}
 * @author     Created on 21-Dec-2010
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

/**
 * LogView tail class.
 *
 * With PHP special features.
 */
class LogViewTailPHP
{
    /**
     * Poll the log file.
     *
     * @param opject LogOptions $options
     *
     * @return object LogViewLog
     */
    public static function pollLog(LogOptions $options)
    {
        static $logs = array();

        $fileName = (string)$options->fileName;
        $maxErrs = (string)$options->maxErrors;

        clearstatcache();

        $mTime = filemtime($fileName);

        if(array_key_exists($fileName, $logs))
        {
            if($mTime == $logs[$fileName]->mTime)
            return $logs[$fileName];
        }

        $log = new LogViewLog;

        $log->mTime = $mTime;
        $log->size = filesize($fileName);

        $f = fopen($fileName, 'r');

        if( ! $f)
        return $log;

        $cursor = -1;
        $errCount = 0;

        fseek($f, $cursor, SEEK_END);

        $char = fgetc($f);

        while($char === "\n"
        || $char === "\r")
        {
            fseek($f, $cursor--, SEEK_END);
            $char = fgetc($f);
        }//while

        $stack = array();
        $isStack = true;

        $char = '';

        while($errCount < $maxErrs)
        {
            $line = '';

            while($char !== false
            && $char !== "\n"
            && $char !== "\r")
            {
                $line = $char.$line;

                fseek($f, $cursor--, SEEK_END);

                $char = fgetc($f);
            }//while

            fseek($f, $cursor--, SEEK_END);

            $char = fgetc($f);

            $line = trim($line);

            if( ! $line)
            continue;

            if( ! $isStack)
            {
                $log->addItem(new ErrorItem($errCount, $line, $stack, 'php'));

                $stack = array();
                $isStack = true;
                $errCount ++;

                continue;
            }

            if(strpos($line, 'PHP Stack trace'))
            {
                $isStack = false;

                continue;
            }

            if(trim($line))
            $stack[] = $line;

            if(false === $char)
            break;
        }//while

        $logs[$fileName] = $log;

        return $log;
    }//function
}//class

/**
 * LogView error link class.
 */
class ErrorLink
{
    public $links = array();

    public $lineNo = 0;

    public $line = '';

    public $dateTime = '';

    public $errorType = '';

    public $error = '';

    public function __construct($line)
    {
        $this->line = $line;

        if(preg_match(
        '|\[(.*)\] PHP (.*): (.*), called in (.*) on line (.*) and defined in (.*) on line (.*)|'
        , $line, $matches))
        {
            $this->dateTime = $matches[1];
            $this->errorType = $matches[2];
            $this->error = $matches[3];

            $this->links[] = $matches[4].':'.$matches[5];
            $this->links[] = $matches[6].':'.$matches[7];

            return;
        }
        else if(preg_match(
        '|\[(.*)\] PHP (.*): (.*) specified in (.*) on line (.*) in (.*) on line (.*)|'
        , $line, $matches))
        {
            $this->dateTime = $matches[1];
            $this->errorType = $matches[2];
            $this->error = $matches[3];

            $this->links[] = $matches[4].':'.$matches[5];
            $this->links[] = $matches[6].':'.$matches[7];

            return;
        }
        else if(preg_match(
        '|\[(.*)\] PHP (.*): (.*) in (.*) on line (\d+(?=\z))|U'
        , $line, $matches))
        {
            $this->dateTime = $matches[1];
            $this->errorType = $matches[2];
            $this->error = $matches[3];

            $this->links[] = $matches[4].':'.$matches[5];

            return;
        }
        else if(preg_match(
        '|\[(.*)\] PHP (.*)\. (.*) (.*(?=\z))|U'
        , $line, $matches))
        {
            $this->dateTime = $matches[1];
            $this->errorType = $matches[2];
            $this->error = $matches[3];

            $this->links[] = $matches[4];

            return;
        }

        echo 'Unable to parse: '.$line;//.NL;
        //        $this->links[] = $parts[0].':'.$parts[1];

        //        $pos = strpos($line, DIRECTORY_SEPARATOR);
        //
        //        if(IS_WINDOWS)
        //        $pos -= 2;//-- windoze has a strange letter to identify the "drive" :P
        //
        //        $s = substr($line, $pos);
        //
        //        if(false != strpos($s, ':'))
        //        {
        //            $this->links[] = $s;
        //
        //            return;
        //        }
        //
        //        $parts = explode(' on line ', $s);
        //
        //        if(count($parts) != 2)
        //        return;
        //
        //        $this->links[] = $parts[0].':'.$parts[1];
    }//function
}//class
