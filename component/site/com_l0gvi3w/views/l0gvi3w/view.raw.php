<?php
/**
 * @version SVN: $Id$
 * @package    L0gVi3w
 * @subpackage Views
 * @author     Nikolai Plath {@link http://nik-it.de}
 * @author     Created on 17-Jul-2011
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

//-- Import the JView class
jimport('joomla.application.component.view');

/**
 * HTML View class for the L0gVi3w Component.
 *
 * @package L0gVi3w
 */
class L0gVi3wViewL0gVi3w extends JView
{
    protected $error_log = '';

    protected $logEntries = array();

    /**
     * L0gVi3w view display method.
     *
     * @param string $tpl The name of the template file to parse;
     *
     * @return void
     */
    public function display($tpl = null)
    {
        jimport('joomla.filesystem.file');

        //-- Check if everything is set up correctly

        $error_log = ini_get('error_log');

        if( ! $error_log)
        {
            $this->setError('The value for error_log in your php.ini file is empty - please specify a path and file.');

            return;
        }

        if( ! JFile::exists($error_log))
        {
            $this->setError(sprintf('The error log file on %s can not be found or is not accessible.', $error_log));

            return;
        }

        $this->error_log = $error_log;
        $this->greeting = 'L0gVi3w';

        $options = new LogOptions;

        $options->fileName = $error_log;
        $options->maxErrors = 10;

        $log = LogViewTailPHP::pollLog($options);

        $entries = $log->getEntries();

        if($entries)
        $this->logEntries = array_reverse($entries);

        $this->setLayout('raw');

        parent::display($tpl);
    }//function

    /**
     * Draws links.
     *
     * @param array $links
     *
     * @return string HTML
     */
    protected function drawLinks($links)
    {
        $html = '';

        $protocol = 'xdebug://';

        foreach($links as $link)
        {
            $tmp = str_replace(':', '@', $link);

            $link = $protocol.$tmp;

            $file = JFile::getName($link);

            $title = str_replace(JPATH_ROOT, 'JROOT', $tmp);

            $html .= '...<a href="'.$link.'" title="'.$title.'">'.$file.'</a>';
        }//foreach

        return $html;
    }//function

    protected function drawDate($dateTime)
    {
        $html = '';

        $html = $dateTime;

        $parts = explode(' ', $dateTime);

        if(2 == count($parts))
        {
            $html = '<div title="'.$dateTime.'">'.$parts[1].'</div>';
        }

        return $html;
    }//function
}//class
