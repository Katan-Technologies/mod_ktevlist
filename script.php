<?php
/**
 *
 * KT Events List!
 * @author     Kathryn Anderson <katan@gokatan.com>
 * @copyright  2023
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://www.gokatan.com
 */

// No direct access to this file
defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;
use Joomla\CMS\HTML\HTMLHelper;


/**
 * Script file of KT Events List module
 */
class mod_ktevlistInstallerScript {

    /**
     * Extension script constructor.
     *
     * @return  void
     */
    public function __construct() {
        $this->minimumJoomla = '4.0';
        $this->minimumPhp = JOOMLA_MINIMUM_PHP;
    }

    /**
     * Method to install the extension
     *
     * @param   InstallerAdapter  $parent  The class calling this method
     *
     * @return  boolean  True on success
     */
    function install($parent) {
        echo Text::_('MOD_KTEVLIST_INSTALLERSCRIPT_INSTALL');

        return true;
    }

    /**
     * Method to uninstall the extension
     *
     * @param   InstallerAdapter  $parent  The class calling this method
     *
     * @return  boolean  True on success
     */
    function uninstall($parent) {
        echo Text::_('MOD_KTEVLIST_INSTALLERSCRIPT_UNINSTALL');

        return true;
    }

    /**
     * Method to update the extension
     *
     * @param   InstallerAdapter  $parent  The class calling this method
     *
     * @return  boolean  True on success
     */
    function update($parent) {
        echo Text::_('MOD_KTEVLIST_INSTALLERSCRIPT_UPDATE');

        return true;
    }

    /**
     * Function called before extension installation/update/removal procedure commences
     *
     * @param   string            $type    The type of change (install, update or discover_install, not uninstall)
     * @param   InstallerAdapter  $parent  The class calling this method
     *
     * @return  boolean  True on success
     */
    function preflight($type, $parent) {
        // Check for the minimum PHP version before continuing
        if (!empty($this->minimumPhp) && version_compare(PHP_VERSION, $this->minimumPhp, '<')) {
            Log::add(Text::sprintf('JLIB_INSTALLER_MINIMUM_PHP', $this->minimumPhp), Log::WARNING, 'jerror');

            return false;
        }

        // Check for the minimum Joomla version before continuing
        if (!empty($this->minimumJoomla) && version_compare(JVERSION, $this->minimumJoomla, '<')) {
            Log::add(Text::sprintf('JLIB_INSTALLER_MINIMUM_JOOMLA', $this->minimumJoomla), Log::WARNING, 'jerror');

            return false;
        }
		
		//testing to see if I can get the installer script to accurately detect whether or not a dependent extension is pre-installed and pre-enabled
		if(!JComponentHelper::isEnabled('com_icagenda',true)){
			Log::add('the icagenda component is not enabled', Log::ERROR, 'mod_ktevlist_check_for_extension');
			echo Text::_('MOD_KTDOWNLOAD_INSTALLERSCRIPT_PREFLIGHT_COMPONENT_NOT_ENABLED');
			return false;
		}else{
			Log::add('the icagenda component is enabled', Log::ERROR, 'mod ktevlist check for extension');
			
		}
		

        return true;
    }

    /**
     * Function called after extension installation/update/removal procedure commences
     *
     * @param   string            $type    The type of change (install, update or discover_install, not uninstall)
     * @param   InstallerAdapter  $parent  The class calling this method
     *
     * @return  boolean  True on success
     */
    function postflight($type, $parent) {

        return true;
    }
}
