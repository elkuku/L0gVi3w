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

echo 'Time '.date('H:i:s').'<br />';

if( ! count($this->logEntries)) :
    echo 'The log is empty :(';

    return;
endif;
?>
<table class="l0gVi3wTable">
<thead>
	<tr>
		<th>DateTime</th>
		<th>Type</th>
		<th>Error / Function</th>
		<th width=5%">Stack</th>
		<th width=10%">File</th>
	</tr>
</thead>
<tbody>
<?php
$i = 0;
foreach ($this->logEntries as $id => $item) :
$message = $item->message;
$class = str_replace(' ', '_', $item->message->errorType);
?>
<tr class="errorEntry row<?php echo $i; ?>">
    <td class="dateTime"><?php echo $this->drawDate($item->message->dateTime); ?></td>
    <td class="<?php echo $class; ?>"><?php echo $item->message->errorType; ?></td>
    <td><?php echo $item->message->error; ?></td>
	<td class="stackLink" onclick="changeState('stack<?php echo $id; ?>');">Stack</td>
	<td><?php echo $this->drawLinks($item->message->links); ?></td>
</tr>
<tr>
<td colspan="5">
<table style="display: none;" class="l0gVi3wTable stack" id="stack<?php echo $id; ?>">
<?php foreach ($item->stack as $stackItem) : ?>
    <tr class="stackEntry">
    	<td width="5%"><?php echo $stackItem->errorType; ?></td>
    	<td><?php echo $stackItem->error; ?></td>
    	<td width=10%"><?php echo $this->drawLinks($stackItem->links); ?></td>
    </tr>
<?php endforeach; ?>

</table>
</td>
</tr>
<?php
$i = 1 - $i;
endforeach; ?>
</tbody>
</table>
