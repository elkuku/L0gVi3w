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
        $response = array();

        $s = '';
        $path = '/home/elkuku/logs/php.errors';

        if( ! JFile::exists($path))
        {
            $s = 'File not found';

            $response['status'] = 1;

            echo json_encode($response);

            return;
        }

        ob_start();

        require_once JPATH_COMPONENT.'/helpers/classes.php';
        require_once JPATH_COMPONENT.'/helpers/tailphp.php';

        $options = new LogOptions;

        $options->fileName = $path;
        $options->maxErrors = 10;

        $log = LogViewTailPHP::pollLog($options);

        $s .= 'Time '.date('H:i:s');
        $s .= '<br />';

        $entries = $log->getEntries();

        $entries = array_reverse($entries);

        foreach ($entries as $item)
        {
            $message = $item->message;
            //echo $message->line;

            echo $message->errorType;

            echo $message->error;

            $link = 'xdebug://';

            $tmp = str_replace(':', '@', $message->links[0]);

            $link .= $tmp;

            $tmp = str_replace(JPATH_ROOT, 'JROOT', $tmp);

            //            $link .= $message->links[0];

            echo '<a href="'.$link.'" title="'.$tmp.'">----&gt;Open</a>';

            echo  '<br />';
        }//foreach

        $contents = ob_get_clean();
        $s .= $contents;

        $response['text'] = $s;

        $response['status'] = 0;

        echo json_encode($response);
    }//function

}//class
