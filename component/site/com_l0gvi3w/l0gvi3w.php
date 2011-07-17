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

//-- Import the class JController
jimport('joomla.application.component.controller');

//-- Get an instance of the controller with the prefix 'L0gVi3w'
$controller = JController::getInstance('L0gVi3w');

//-- Execute the 'task' from the Request
$controller->execute(JRequest::getCmd('task'));

//-- Redirect if set by the controller
$controller->redirect();
