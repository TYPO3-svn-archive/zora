<?php

########################################################################
# Extension Manager/Repository config file for ext "zora".
#
# Auto generated 10-07-2012 14:41
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Zora',
	'description' => 'Creates Zora queries and displays results',
	'category' => 'plugin',
	'author' => 'Christoph Fuchs',
	'author_email' => 'Christoph.Fuchs@mnf.uzh.ch',
	'author_company' => 'University of Zurich, Faculty of Science',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.0.2',
	'constraints' => array(
		'depends' => array(
			'extbase' => '1.3',
			'fluid' => '1.3',
			'typo3' => '4.5-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:38:{s:21:"ExtensionBuilder.json";s:4:"5e53";s:12:"ext_icon.gif";s:4:"aa7e";s:17:"ext_localconf.php";s:4:"4d38";s:14:"ext_tables.php";s:4:"353f";s:14:"ext_tables.sql";s:4:"ce01";s:37:"Classes/Controller/ZoraController.php";s:4:"7083";s:29:"Classes/Domain/Model/Zora.php";s:4:"3535";s:44:"Classes/Domain/Repository/ZoraRepository.php";s:4:"77de";s:37:"Classes/Utils/class.tx_zora_utils.php";s:4:"7c8b";s:44:"Configuration/ExtensionBuilder/settings.yaml";s:4:"370e";s:44:"Configuration/FlexForms/advancedSearchBE.xml";s:4:"b9ec";s:39:"Configuration/FlexForms/flexform_ds.xml";s:4:"8082";s:43:"Configuration/FlexForms/savedSearchIdBE.xml";s:4:"4775";s:41:"Configuration/FlexForms/selectQueryFE.xml";s:4:"6139";s:32:"Configuration/FlexForms/test.xml";s:4:"ee1b";s:32:"Configuration/FlexForms/zora.xml";s:4:"d64a";s:26:"Configuration/TCA/Zora.php";s:4:"898a";s:38:"Configuration/TypoScript/constants.txt";s:4:"cdb1";s:34:"Configuration/TypoScript/setup.txt";s:4:"9f14";s:40:"Resources/Private/Language/locallang.xml";s:4:"0cc6";s:53:"Resources/Private/Language/locallang_ZoraFlexForm.xml";s:4:"c9cf";s:54:"Resources/Private/Language/locallang_csh_FlexForms.xml";s:4:"a668";s:70:"Resources/Private/Language/locallang_csh_tx_zora_domain_model_zora.xml";s:4:"1fcb";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"21bd";s:38:"Resources/Private/Layouts/Default.html";s:4:"d123";s:47:"Resources/Private/Partials/Zora/Properties.html";s:4:"a185";s:43:"Resources/Private/Partials/Zora/author.html";s:4:"a8c6";s:41:"Resources/Private/Partials/Zora/book.html";s:4:"a8c6";s:42:"Resources/Private/Templates/Zora/List.html";s:4:"9650";s:29:"Resources/Public/CSS/auto.css";s:4:"3d15";s:29:"Resources/Public/CSS/zora.css";s:4:"cf3a";s:37:"Resources/Public/CSS/zoraOriginal.css";s:4:"809b";s:42:"Resources/Public/Icons/application_pdf.png";s:4:"eec0";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:52:"Resources/Public/Icons/tx_zora_domain_model_zora.gif";s:4:"c466";s:44:"Tests/Unit/Controller/ZoraControllerTest.php";s:4:"4d8e";s:36:"Tests/Unit/Domain/Model/ZoraTest.php";s:4:"76eb";s:14:"doc/manual.sxw";s:4:"2997";}',
);

?>