<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin 4.0.0                                                  # ||
|| # ---------------------------------------------------------------- # ||
|| # Copyright ©2000-2009 vBulletin Solutions Inc. All Rights Reserved. ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
|| # http://www.vbulletin.com | http://www.vbulletin.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/

// ####################### SET PHP ENVIRONMENT ###########################
error_reporting(E_ALL & ~E_NOTICE);

// #################### DEFINE IMPORTANT CONSTANTS #######################
define('THIS_SCRIPT', 'fshop');
define('CSRF_PROTECTION', true);
define('CSRF_SKIP_LIST', '');
define('VB_ENTRY', 'fshop.php');
// ################### PRE-CACHE TEMPLATES AND DATA ######################
// get special phrase groups
$phrasegroups = array('user');

// get special data templates from the datastore
$specialtemplates = array();

// pre-cache templates used by all actions
$globaltemplates = array('Fun Shop');

// pre-cache templates used by specific actions
$actiontemplates = array();

// ######################### REQUIRE BACK-END ############################
require_once('./global.php');
require_once(DIR . '/includes/functions_user.php');
require_once(DIR . '/fshop/fshop_setting.php');


$setting1 = setting(1);
$setting2 = setting(2);
$setting3 = setting(3);
$setting4 = setting(4);
$setting5 = setting(5);
$setting6 = setting(6);
$setting7 = setting(7);
$setting8 = setting(8);
$setting9 = setting(9);
$setting10 = setting(10);
$setting11 = setting(11);
	if($setting1==0)
	{
	eval('standard_error($setting2);');
    }
    
$userid = $vbulletin->userinfo['userid'];
  if($userid==0)
  {
 	standard_error(fetch_error('session_timed_out_login'), '', false, 'STANDARD_ERROR_LOGIN'); 
  }
$username = $vbulletin->userinfo['username'];
$usertitle = $vbulletin->userinfo['usertitle'];
$showtitle = html_cut($usertitle,15);
$showtitle = str_replace("<p>","",$usertitle);
$showtitle = str_replace("</p>","",$usertitle);


$usergroupid = $vbulletin->userinfo['usergroupid'];
$displaygroupid = $vbulletin->userinfo['displaygroupid'];
$usermoney = $vbulletin->userinfo[$setting3];
$upcasemoney = strtoupper($setting4);

	$query = $vbulletin->db->query_read("SELECT * FROM " . TABLE_PREFIX . "usergroup WHERE usergroupid='$displaygroupid'");   
    $usergroupnames = $vbulletin->db->fetch_array($query);
$usergroupname = $usergroupnames['opentag'].$usergroupnames['title'].$usergroupnames['closetag'];

  $getavatar = fetch_avatar_url($userid);
    $getavatar = @$getavatar[0];
     if (empty($getavatar)) 
    {
    $getavatar = 'images/misc/unknown.gif';
    }
    
$amountitems = getamountitems();    
$amountuseritems = getamountitemusers($userid);
$amountview = getamountview($userid);
$amountevent = getamountevent($userid);
$amountmanagerevent = getamountmanagerevent();

$linkdobuy="$vbphrase[fshop_shop] ($amountitems)";
$linkdoequip="$vbphrase[fshop_equip] ($amountuseritems)";
$linkdoview="$vbphrase[fshop_viewing] ($amountview)";
$linkdoevent="$vbphrase[fshop_event] ($amountevent)"; 
$linkdomanagerevent="$vbphrase[fshop_managerevent] ($amountmanagerevent)"; 
 
$getfshop = $_GET['do'];
  if(!$getfshop)
   {
include("fshop/fshop_buy.php");
$linkdobuy="<font color='orange'><u>$vbphrase[fshop_shop] ($amountitems)</u></font>";
   }elseif($getfshop=="buy")
   {
 include("fshop/fshop_dobuy.php");   
 $linkdobuy="<font color='orange'><u>$vbphrase[fshop_shop] ($amountitems)</u></font>";
   }
   elseif($getfshop=="equip")
   {
 include("fshop/fshop_useritem.php");   
 $linkdoequip="<font color='orange'><u>$vbphrase[fshop_equip] ($amountuseritems)</u></font>";
   }
    elseif($getfshop=="use")
   {
 include("fshop/fshop_use.php");   
  $linkdoequip="<font color='orange'><u>$vbphrase[fshop_equip] ($amountuseritems)</u></font>";
   }
   elseif($getfshop=="view")
   {
 include("fshop/fshop_view.php");   
 $linkdoview="<font color='orange'><u>$vbphrase[fshop_viewing] ($amountview)</u></font>";
   }
    elseif($getfshop=="event")
   {
 include("fshop/fshop_event.php");   
 $linkdoevent="<font color='orange'><u>$vbphrase[fshop_event] ($amountevent)</u></font>";
   }
   elseif($getfshop=="eventid")
   {
 include("fshop/fshop_eventid.php");   
  $linkdoevent="<font color='orange'><u>$vbphrase[fshop_event] ($amountevent)</u></font>";
   }
    elseif($getfshop=="managerevent")
   {
 include("fshop/fshop_managerevent.php");   
 $linkdomanagerevent="<font color='orange'><u>$vbphrase[fshop_managerevent] ($amountmanagerevent)</u></font>";
   }
   elseif($getfshop=="managercheck")
   {
 include("fshop/fshop_managercheck.php");   
  $linkdomanagerevent="<font color='orange'><u>$vbphrase[fshop_managerevent] ($amountmanagerevent)</u></font>";
   }  
  elseif($getfshop=="request")
   {
 include("fshop/fshop_request.php");
  }
$checkusermanager = explode(",",$setting11);
 if(in_array($userid,$checkusermanager))
   {
  $showeventmanager=1; 
   }
$navbits = construct_navbits(array('' => 'FUN SHOP'));
$navbar = render_navbar_template($navbits);

$templater = vB_Template::create('fshop_board');
$templater->register('fshop_buy', $fshop_buy);
$templater->register('fshop_useritem', $fshop_useritem);
$templater->register('fshop_dobuy', $fshop_dobuy);
$templater->register('fshop_use', $fshop_use);
$templater->register('fshop_view', $fshop_view);
$templater->register('fshop_event', $fshop_event);
$templater->register('fshop_managerevent', $fshop_managerevent);
$templater->register('fshop_managercheck', $fshop_managercheck);
$templater->register('fshop_eventid', $fshop_eventid);
$templater->register('fshop_request', $fshop_request);
$HTML = $templater->render();


$templater = vB_Template::create('fshop_home');
$templater->register_page_templates();
$templater->register('navbar', $navbar);
$templater->register('HTML', $HTML);
$templater->register('setting1', $setting1);
$templater->register('setting2', $setting2);
$templater->register('setting4', $setting4);
$templater->register('userid', $userid);
$templater->register('username', $username);
$templater->register('getavatar', $getavatar);
$templater->register('usertitle', $usertitle);
$templater->register('showtitle', $showtitle);
$templater->register('usergroupname', $usergroupname);
$templater->register('usermoney', $usermoney);
$templater->register('upcasemoney', $upcasemoney);
$templater->register('linkdobuy', $linkdobuy);
$templater->register('linkdoequip', $linkdoequip);
$templater->register('linkdoview', $linkdoview);
$templater->register('linkdoevent', $linkdoevent);
$templater->register('linkdomanagerevent', $linkdomanagerevent);
$templater->register('showeventmanager', $showeventmanager);
$templater->register('titlestart', $titlestart);
print_output($templater->render());





/*======================================================================*\
|| ####################################################################
|| # CVS: $RCSfile$ - $Revision: 29207 $
|| ####################################################################
\*======================================================================*/
?>
