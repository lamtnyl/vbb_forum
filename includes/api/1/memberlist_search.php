<?php
/*======================================================================*\
|| #################################################################### ||
|| # vBulletin 4.1.11
|| # ---------------------------------------------------------------- # ||
|| # Copyright �2000-2012 vBulletin Solutions Inc. All Rights Reserved. ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- VBULLETIN IS NOT FREE SOFTWARE ---------------- # ||
|| # http://www.vbulletin.com | http://www.vbulletin.com/license.html # ||
|| #################################################################### ||
\*======================================================================*/
if (!VB_API) die;

loadCommonWhiteList();

$VB_API_WHITELIST = array(
	'response' => array(
		'customfields' => array(
			'*' => array(
				'optionalfield' => array(
					'optional', 'optionalname'
				),
				'profilefield' => array(
					'type', 'editable', 'optional', 'title', 'description', 'required', 'currentvalue'
				),
				'radiobits', 'selectbits'
			)
		)
	),
	'show' => array()
);

/*======================================================================*\
|| ####################################################################
|| # CVS: $RCSfile$ - $Revision: 35584 $
|| ####################################################################
\*======================================================================*/