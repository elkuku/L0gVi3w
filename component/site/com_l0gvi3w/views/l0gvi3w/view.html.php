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

        if( ! ini_get('log_errors'))
        {
            JError::raiseWarning(0, 'Error logging is set to OFF'
            .' - please set the value for log_errors to ON in your php.ini file.');

            return;
        }

        $error_log = ini_get('error_log');

        if( ! $error_log)
        {
            JError::raiseWarning(0, 'The value for error_log in your php.ini file is empty'
            .' - please specify a path and file.');

            return;
        }

        if( ! JFile::exists($error_log))
        {
            JError::raiseWarning(0, sprintf(
            'The error log file on %s can not be found or is not accessible.', $error_log));

            return;
        }

        $this->error_log = $error_log;
        $this->greeting = 'L0gVi3w';

        parent::display($tpl);
    }//function
}//class
