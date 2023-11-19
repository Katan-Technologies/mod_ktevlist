<?php
/**
 * KT Downloads! Module Entry Point
 * 
 * @subpackage Modules
 * @license    GNU/GPL, see LICENSE.php
 * @link       http://www.gokatan.com
 * mod_ktdownload is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// No direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

$cat = $params->get('title', '1');
$maxentries = $params->get('maxentries','1');
//$img = $params->get('ktdlimage','1');
$ktevlist     = modKtEvListHelper::getList( $cat );

require JModuleHelper::getLayoutPath('mod_ktevlist');
