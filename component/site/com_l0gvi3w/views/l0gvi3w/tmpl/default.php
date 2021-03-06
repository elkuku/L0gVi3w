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

JFactory::getDocument()->addScript('components/com_l0gvi3w/assets/js/l0gvi3w.js');
JFactory::getDocument()->addStyleSheet('components/com_l0gvi3w/assets/css/l0gvi3w.css')
?>
<script>
function changeState(id)
{
    var el = document.getElementById(id);

    el.style.display = (el.style.display != 'none' ? 'none' : '' )
}
</script>

<h1><?php echo $this->greeting; ?></h1>

<?php echo sprintf('Ready to read your log file at <code>%s</code>', $this->error_log); ?>
<br />

<a class="btn" id="l0gvi3wStart" href="javascript:;" onclick="startPoll();"><i class="icon-play"></i> Start</a>
<a class="btn active" id="l0gvi3wStop" href="javascript:;" onclick="stopPoll();"><i class="icon-stop"></i> Stop</a>

<div id="pollStatus">idle</div>

<div id="pollLog"></div>
