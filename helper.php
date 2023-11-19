<?php
// No direct access
defined('_JEXEC') or die;
/**
 * Helper class for KT Downloads module
 * 
 * @subpackage Modules
 * @license        GNU/GPL, see LICENSE.php
 * @link       http://www.gokatan.com
 * mod_ktdownload is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

class ModKtEvListHelper
{
	/**
	* Retrieves the message
	*
	* @param   array  $params An object containing the module parameters
	*
	* @access public
	*/    
	public static function getList($params)
	{
		// Obtain a database connection
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Order it by the created date.
		// Note by putting 'a' as a second parameter will generate `#__content` AS `a`
		$query
			->select(array('a.title', 'a.alias','a.id', 'a.catid', 'a.image', 'a.place','a.city','a.address','a.startdate', 'a.enddate', 'a.period', 'a.dates', 'a.next', ))
			->select($db->quoteName(array('b.title','b.alias','b.id','b.color','b.desc'), array('catTitle','catAlias','catID','catColor','catDesc')))
			->from($db->quoteName('#__icagenda_events', 'a'))
			->join('INNER', $db->quoteName('#__icagenda_category', 'b') . ' ON ' . $db->quoteName('a.catid') . ' = ' . $db->quoteName('b.id'))
			->where($params . ' LIKE ' . $db->quoteName('b.id') . ' OR '.$params.' LIKE 0'.' AND ' . $db->quoteName('b.id') . ' LIKE ' . $db->quoteName('a.catid'). ' AND ' . $db->quoteName('a.state') . ' LIKE 1')//also where state = 1 for both category and event, or at least for event
			->order($db->quoteName('a.next') . ' DESC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();

		return $results;
    }
}