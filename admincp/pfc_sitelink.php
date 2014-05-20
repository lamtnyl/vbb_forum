<?php
/*===================================================================*\
***	SiteLink for vbulletin 4.0 
×××	©PHP源动力 	PHPFORCE.CN
*** author： Joey
\*===================================================================*/

// ######################## SET PHP ENVIRONMENT ###########################
error_reporting(E_ALL & ~E_NOTICE);

// ##################### DEFINE IMPORTANT CONSTANTS #######################
define('NO_REGISTER_GLOBALS', 1);

// #################### PRE-CACHE TEMPLATES AND DATA ######################
$phrasegroups = array('cphome', 'profilefield', 'forum');
$specialtemplates = array();

// ########################## REQUIRE BACK-END ############################
require_once('./global.php');

// ############################# LOG ACTION ###############################
$vbulletin->input->clean_array_gpc('r', array(
	'sitelinkid' 	=> TYPE_INT
));
log_admin_action(iif($vbulletin->GPC['sitelinkid'] != 0, "sitelink id = " . $vbulletin->GPC['sitelinkid']));

// ########################################################################
// ######################### START MAIN SCRIPT ############################
// ########################################################################

print_cp_header($vbphrase['pfc_sitelink_manager']);

if (empty($_REQUEST['do']))
{
	$_REQUEST['do'] = 'modify';
}

// ###################### Start edit #######################
if ($_REQUEST['do'] == 'edit')
{
	print_form_header('pfc_sitelink', 'update');
	if (isset($_REQUEST['sitelinkid']))
	{
		$sitelink = $db->query_first("SELECT * FROM " . TABLE_PREFIX . "sitelink WHERE sitelinkid = " . intval($_REQUEST['sitelinkid']));
		print_table_header(construct_phrase($vbphrase['x_y_id_z'], $vbphrase['pfc_sitelink'], $sitelink['title'], $sitelink['sitelinkid']));
		construct_hidden_code('sitelinkid' , $sitelink['sitelinkid']);
	}
	else
	{
		$sitelink['url'] = 'http://';
		$sitelink['logourl'] = 'http://';
		print_table_header($vbphrase['pfc_add_new_sitelink']);
	}
	
	print_input_row($vbphrase['name'], 'title', $sitelink['title']);
	print_input_row($vbphrase['link'], 'url', $sitelink['url']);
	print_input_row($vbphrase['pfc_sitelink_logourl'], 'logourl', $sitelink['logourl']);
	print_textarea_row($vbphrase['pfc_sitelink_description'], 'desc', $sitelink['description']);
	print_input_row($vbphrase['display_order'], 'displayorder', $sitelink['displayorder']);
	print_yes_no_row($vbphrase['pfc_sitelink_fullrow'], 'fullrow', $sitelink['fullrow']);
	print_submit_row($vbphrase['save']);
}

// ###################### Start do update #######################
if ($_POST['do'] == 'update')
{
	$vbulletin->input->clean_array_gpc('p', array(
		'title' => TYPE_STR,
		'url' => TYPE_STR,
		'logourl' => TYPE_STR,
		'desc' => TYPE_STR,
		'sitelinkid' => TYPE_INT,
		'displayorder' => TYPE_INT,
		'fullrow'	=> TYPE_BOOL,
	));
	
	
	if (empty($vbulletin->GPC['sitelinkid']))
	{
		// add new
		$db->query("
			INSERT INTO " . TABLE_PREFIX . "sitelink
			(`title`, `url`, `logourl`, `description`, `displayorder`,`fullrow`)
			VALUES
			('" . $db->escape_string($vbulletin->GPC['title']) . "', '" . $db->escape_string($vbulletin->GPC['url']) . "', '" . $db->escape_string($vbulletin->GPC['logourl']) . "','" . $db->escape_string($vbulletin->GPC['desc']) . "','" . $vbulletin->GPC['displayorder'] . "','" . $vbulletin->GPC['fullrow'] . "')
		");	
	}
	else
	{
		// update
		$db->query("
			UPDATE " . TABLE_PREFIX . "sitelink
			SET `title` = '" . $db->escape_string($vbulletin->GPC['title']) . "',
			`url` = '" . $db->escape_string($vbulletin->GPC['url']) . "',
			`logourl` = '" . $db->escape_string($vbulletin->GPC['logourl']) . "',
			`description` = '" . $db->escape_string($vbulletin->GPC['desc']) . "',
			`displayorder` = '" . $vbulletin->GPC['displayorder'] . "',
			`fullrow` = '" . $vbulletin->GPC['fullrow'] . "'
			WHERE `sitelinkid` = " . $vbulletin->GPC['sitelinkid']
		);
	}

	// 更新缓存
	$sitelinks = $db->query("SELECT * FROM " . TABLE_PREFIX . "sitelink ORDER BY displayorder");
	while ($sitelink = $db->fetch_array($sitelinks))
	{
		$sitelinkcache[] = $sitelink;
	}
	build_datastore('sitelinkcache', serialize($sitelinkcache),1);
	
	
	define('CP_REDIRECT', 'pfc_sitelink.php?$session[sessionurl]do=modify');
	print_stop_message('pfc_saved_sitelink_x_successfully', $vbulletin->GPC['title']);

}

// ###################### Start Update Display Order #######################
if ($_POST['do'] == 'dodisplayorder')
{
	$vbulletin->input->clean_array_gpc('r', array(
		'order' 	=> TYPE_NOCLEAN
	));
	
	if (is_array($vbulletin->GPC['order']))
	{
		$sitelinks = $db->query("
			SELECT sitelinkid,displayorder
			FROM " . TABLE_PREFIX . "sitelink
		");
		while ($sitelink = $db->fetch_array($sitelinks))
		{
			$displayorder = intval($vbulletin->GPC['order']["$sitelink[sitelinkid]"]);
			if ($sitelink['displayorder'] != $displayorder)
			{
				$db->query("
					UPDATE " . TABLE_PREFIX . "sitelink
					SET displayorder = $displayorder
					WHERE sitelinkid = $sitelink[sitelinkid]
				");
			}
		}
	}

	// 更新缓存
	$sitelinks = $db->query("SELECT * FROM " . TABLE_PREFIX . "sitelink ORDER BY displayorder");
	while ($sitelink = $db->fetch_array($sitelinks))
	{
		$sitelinkcache[] = $sitelink;
	}
	build_datastore('sitelinkcache', serialize($sitelinkcache),1);


	define('CP_REDIRECT', "pfc_sitelink.php?$session[sessionurl]do=modify");
	print_stop_message('saved_display_order_successfully', CP_REDIRECT);
	
	
}

// ###################### Start Remove Sitelink #######################
if ($_REQUEST['do'] == 'remove')
{
	$vbulletin->input->clean_array_gpc('r', array(
		'sitelinkid' 	=> TYPE_INT
	));

	echo "<p>&nbsp;</p><p>&nbsp;</p>\n";

	print_form_header('pfc_sitelink', 'kill');
	construct_hidden_code('sitelinkid', $vbulletin->GPC['sitelinkid']);
	print_table_header($vbphrase['confirm_deletion']);
	print_description_row($vbphrase['pfc_are_you_sure_you_want_to_delete_this_sitelink']);
	print_submit_row($vbphrase['delete'], '', 2, $vbphrase['go_back']);
}

// ###################### Start Kill #######################
if ($_POST['do'] == 'kill')
{
	$vbulletin->input->clean_array_gpc('r', array(
		'sitelinkid' 	=> TYPE_INT
	));

	$db->query("DELETE FROM " . TABLE_PREFIX . "sitelink WHERE sitelinkid = ".$vbulletin->GPC['sitelinkid']);

	// 更新缓存
	$sitelinks = $db->query("SELECT * FROM " . TABLE_PREFIX . "sitelink ORDER BY displayorder");
	while ($sitelink = $db->fetch_array($sitelinks))
	{
		$sitelinkcache[] = $sitelink;
	}
	build_datastore('sitelinkcache', serialize($sitelinkcache),1);

	
	define('CP_REDIRECT', "pfc_sitelink.php?$session[sessionurl]do=modify");
	print_cp_message($vbphrase['pfc_deleted_sitelink_successfully'], CP_REDIRECT);

}

// ###################### Start Modify Sitelinks #######################
if ($_REQUEST['do'] == 'modify')
{
	$sitelinks = $db->query("SELECT * FROM " . TABLE_PREFIX . "sitelink ORDER BY displayorder");
	
	if ($db->num_rows($sitelinks))
	{
		print_form_header('pfc_sitelink', 'dodisplayorder');
		print_table_header($vbphrase['pfc_sitelink'], 5);
		print_cells_row(array($vbphrase['name'], $vbphrase['pfc_sitelink_logo'], $vbphrase['pfc_sitelink_fullrow_s'], $vbphrase['display_order'], $vbphrase['controls']), 1);
		
		while ($sitelink = $db->fetch_array($sitelinks))
		{
			$cell = array();
			$cell[] = "<a href=\"$sitelink[url]\">$sitelink[title]</a>";
			if ($sitelink[logourl] == "" || $sitelink[logourl] == 'http://')
				{
				$cell[] = $vbphrase['pfc_sitelink_text'];
				}
				else
				{
				$cell[] = "<img src=\"$sitelink[logourl]\" border=\"0\" width=\"88\" height=\"31\"/>";
				}
			$cell[] = $sitelink[fullrow] ? $vbphrase['yes'] :$vbphrase['no'];
			$cell[] = "<input type=\"text\" class=\"bginput\" name=\"order[$sitelink[sitelinkid]]\" value=\"$sitelink[displayorder]\" tabindex=\"1\" size=\"3\" />";
			$cell[] =
				construct_link_code($vbphrase['edit'], "pfc_sitelink.php?$session[sessionurl]do=edit&amp;sitelinkid=$sitelink[sitelinkid]").
				construct_link_code($vbphrase['delete'], "pfc_sitelink.php?$session[sessionurl]do=remove&amp;sitelinkid=$sitelink[sitelinkid]");
			print_cells_row($cell);
		}
		
		print_submit_row($vbphrase['save_display_order'], "_default_", 5);
	}
		echo "<p align=\"center\">
		<button  onClick=\"location.href='pfc_sitelink.php?$session[sessionurl]do=edit'\">".$vbphrase['pfc_add_new_sitelink']."</button>
		<button  onClick=\"location.href='phrase.php?$session[sessionurl]do=edit&fieldname=global&varname=pfc_sitelink'\">".$vbphrase['translations']."[".$vbphrase['pfc_sitelink']."]</button>
		</p><br />";
	if (!$db->num_rows($sitelinks))
	{
		print_stop_message("pfc_no_sitelink_found", "pfc_sitelink.php?$session[sessionurl]do=add");
	}

}

print_cp_footer();

/*===================================================================*\
***	SiteLink for vbulletin 4.0 
×××	©PHP源动力 	PHPFORCE.CN
*** author： Joey
\*===================================================================*/
?>
