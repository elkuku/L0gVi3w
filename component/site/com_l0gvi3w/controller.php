<?php
/**
 * @version SVN: $Id$
 * @package    L0gVi3w
 * @subpackage Base
 * @author     Nikolai Plath {@link http://nik-it.de}
 * @author     Created on 17-Jul-2011
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

jimport('joomla.application.component.controller');

/**
 * L0gVi3w Controller.
 *
 * @package    L0gVi3w
 * @subpackage Controllers
 */
class L0gVi3wController extends JController
{
    public function pollLog()
    {
        jimport('joomla.filesystem.file');

        require_once JPATH_COMPONENT.'/helpers/classes.php';
        require_once JPATH_COMPONENT.'/helpers/tailphp.php';

        $response = array();

        $path = ini_get('error_log');

        if( ! JFile::exists($path))
        {
            $response['text'] = 'File not found';

            $response['status'] = 1;

            echo json_encode($response);

            return;
        }

        JRequest::setVar('view', 'l0gvi3w');

        ob_start();

        parent::display();

        $response['text'] = ob_get_clean();
        $response['status'] = 0;

        $view = $this->getView();

        $error = $view->getError();

        if($error)
        {
            $response['text'] = $error.$response['text'];

            $response['status'] = 1;
        }

        echo json_encode($response);
    }//function

}//class
