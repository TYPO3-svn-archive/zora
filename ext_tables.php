<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Zoraquery',
	'Zora Query'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Zora');

			t3lib_extMgm::addLLrefForTCAdescr('tx_zora_domain_model_zora', 'EXT:zora/Resources/Private/Language/locallang_csh_tx_zora_domain_model_zora.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_zora_domain_model_zora');
			$TCA['tx_zora_domain_model_zora'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:zora/Resources/Private/Language/locallang_db.xml:tx_zora_domain_model_zora',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Zora.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_zora_domain_model_zora.gif'
				),
			);

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
	
$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_zoraquery'; // _lowercase
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/selectQueryFE.xml');

//t3lib_extMgm::addLLrefForTCAdescr('*', 'EXT:zora/Resources/Private/Language/locallang_csh_FlexForms.xml');

// utility functions
include_once(t3lib_extMgm::extPath($_EXTKEY).'/Classes/Utils/class.tx_zora_utils.php');
?>