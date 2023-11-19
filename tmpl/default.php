<?php 
// No direct access
defined('_JEXEC') or die; 
/**
 * Template for KT Events List module
 * 
 * @subpackage Modules
 * @license        GNU/GPL, see LICENSE.php
 * @link       http://www.gokatan.com
 * mod_ktdownload is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
?>
<?php 
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
$uri = Uri::getInstance();
$url = $uri->toString();
	// Set the new timezone

$tz=date_default_timezone_get();

if($tz!=='UTC'){
	date_default_timezone_set('UTC'); 
	
	if (date_default_timezone_get()) {
		//echo 'date_default_timezone_set: ' . date_default_timezone_get() . '<br />';
	}
}
$currentDateTime = date('Y-m-d H:i:s');
echo '<script src="https://kit.fontawesome.com/292543daea.js" crossorigin="anonymous"></script>';
echo '<link rel="stylesheet" href="modules/mod_ktevlist/css/style.css">';

$count = 1;

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

$currentDateTime = strtotime($currentDateTime);
$currentDate = date('Y-m-d');
$currentDate = strtotime($currentDate);
$num=0;
if(count($ktevlist)==0){echo 'There are no upcoming events to display<br/>';}else{
foreach($ktevlist as $list){
//if event is not past ...
	if(gettype($list)=='object'){
		$timestamp = strtotime($list->next);
		$ktEvDay = date("jS", $timestamp);
		$ktEvMo = date("F",$timestamp);
		$ktEvYr = date("Y",$timestamp);
		$ktEvTime = date("h:i A",$timestamp);
		$ktEvDate = date('Y-m-d', $timestamp);
		$ktEvDateStamp = strtotime($ktEvDate);
		$dates;
		if(!str_contains($list->startdate, '0000-00-00 00:00:00')){
			$dates = $list->startdate.' - '.$list->enddate;
			$dates = $list->dates;
			$dates = get_string_between($dates,'"','"');
			$timestamp = strtotime($dates);
		}
		//start if event date is greater than or equal to the current date
		if($ktEvDateStamp>=$currentDate){
			$ktEvID = $list->id;
			echo htmlspecialchars($list->alias, ENT_SUBSTITUTE);
			$ktEvAlias = $list->alias;
        	//need to check if SEF URL's are enabled or not
			$ktEvURL = Uri::root().'index.php/component/icagenda/'.$ktEvID.'-'.$ktEvAlias;
			echo '<div class="ktEvListItem"><a href="'.$ktEvURL.'" target="_blank"><div class="ktEvTease">';
			//get the event image if it exists, if not, then get an image from the category if it exists
			$img;
			if(!empty($list->image)){
				$img=$list->image;
				$img = substr($img, 0, strpos($img, "#"));
				$img='<img src="'.Uri::root().$img.'"/>';
			}else{
				$img=$list->catDesc;
				$img = get_string_between($img, '<img', '/>');
				$img = '<img '.$img.'/>';
			}
		
			echo '<div class="ktEvImg" style="border:3px solid '.$list->catColor.';">'.$img;
			echo '</div><div class="ktEvCont">';
			echo '<div class="ktEvTitle"><h4>'.$list->title.'</h4></div>';
			echo '<div class="ktEvCatTitle"><span style="font-size: small;font-style: italic;">'.$list->catTitle.'</span></div>';
			echo '<div class="ktEvDate">';
			if(isset($dates)){echo $dates;}
			echo '<span class="ktEvDay"><i class="fa-regular fa-calendar-days"></i> '.$ktEvDay.' </span><span class="ktEvMo">'.$ktEvMo.' </span><span class="ktEvYr">'.$ktEvYr.'</span></div>';
			echo '<div class="ktEvTime"> <i class="fa-regular fa-clock"></i> '.$ktEvTime.'</div>';
			echo '<div class="ktEvLoc">';
			if(!empty($list->place)&&!empty($list->city)){
				echo ' <i class="fa-solid fa-location-dot"></i> <span class="PA">'.$list->place.', '.$list->city.'</span>';
			}
			elseif(!empty($list->place)&&empty($list->city)){
				echo ' <i class="fa-solid fa-location-dot"></i> <span class="P">'.$list->place.'</span>';
			}
			elseif(!empty($list->city)&&empty($list->place)){
				echo ' <i class="fa-solid fa-location-dot"></i> <span class="A">'.$list->city.'</span>';
			}
			echo '</div>';
			echo '</div>';
			echo '</div></a></div>';	
			if($maxentries!=0 && $maxentries==$count){
				break;
			}
			$count++;
			$num++;
		}
    }
	
	if($num == 0){
		echo 'There are no upcoming events to display<br/>';
	}
}
//need to check if SEF URL's are enabled
$compURL = JURI::root().'index.php/events';
echo '<p class="ktEvLstBtn" style="background-color: orange;border-radius: 10px;padding: 5px 10px 5px 10px;margin-top: 10px;display: inline-flex;float: right;"><a href="'.$compURL.'" target="_blank">View All Events</a></p>';
}//end of if else statement
?>
