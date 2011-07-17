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

JHtml::_('behavior.mootools');

JFactory::getDocument()->addScript('components/com_l0gvi3w/assets/js/poll.js');
JFactory::getDocument()->addStyleSheet('components/com_l0gvi3w/assets/css/l0gvi3w.css')
?>

<h1><?php echo $this->greeting; ?></h1>

<?php echo sprintf('Ready to read your log file at %s', $this->error_log); ?>
<br />

<a href="javascript:;" onclick="startPoll();">start</a>
<a href="javascript:;" onclick="stopPoll();">stop</a>

<div id="pollStatus"></div>

<div id="pollLog"></div>
