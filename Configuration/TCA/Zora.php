<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_zora_domain_model_zora'] = array(
	'ctrl' => $TCA['tx_zora_domain_model_zora']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, last_update, zora_query_type, flex_form, serialized',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, last_update, zora_query_type, flex_form, serialized,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_zora_domain_model_zora',
				'foreign_table_where' => 'AND tx_zora_domain_model_zora.pid=###CURRENT_PID### AND tx_zora_domain_model_zora.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:zora/Resources/Private/Language/locallang_db.xml:tx_zora_domain_model_zora.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'last_update' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:zora/Resources/Private/Language/locallang_db.xml:tx_zora_domain_model_zora.last_update',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'zora_query_type' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:zora/Resources/Private/Language/locallang_db.xml:tx_zora_domain_model_zora.zora_query_type',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => 'required'
			),
		),
		'flex_form' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:zora/Resources/Private/Language/locallang_db.xml:tx_zora_domain_model_zora.flex_form',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'serialized' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:zora/Resources/Private/Language/locallang_db.xml:tx_zora_domain_model_zora.serialized',
			'config' => array(
				'type' => 'mediumtext',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
	),
);

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
$TCA['tx_zora_domain_model_zora']['columns']['serialized']['config']['type'] = 'mediumtext';
// EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is
// overwritten with the defaults of the extension builder
$TCA['tx_zora_domain_model_zora']['columns']['zora_query_type'] = array (
	'exclude' => 0,
	'label' => 'zora_query_type sheet title',
	'config' => array (
			'type' => 'input',
			'eval' => 'int'
	)
);

//unset($TCA['tx_zora_domain_model_zora']['columns']['flex_form'] );
$TCA ['tx_zora_domain_model_zora'] ['columns'] ['flex_form'] = array (
		'exclude' => 0,
		'label' => 'LLL:EXT:zora/Resources/Private/Language/locallang_ZoraFlexForm.xml:savedSearchBE.flexFormData',
		'config' => array (
			'type' => 'flex',
			'ds_pointerField' => 'zora_query_type',
			'ds' => array( 
				'default' => 'FILE:EXT:zora/Configuration/FlexForms/savedSearchIdBE.xml',
				'1' => 'FILE:EXT:zora/Configuration/FlexForms/advancedSearchBE.xml'
			)
		) 
);
// define column where queryType ist stored
$TCA ['tx_zora_domain_model_zora'] ['ctrl'] ['type'] = 'zora_query_type';

// last updated (datetime) is read only
$TCA['tx_zora_domain_model_zora']['columns']['last_update']['config']['readOnly'] = 1;
$TCA['tx_zora_domain_model_zora']['columns']['last_update']['config']['size'] = 11;

// serialized must be a mediumtecct field
$TCA['tx_zora_domain_model_zora']['columns']['serialized']['config']['type'] = 'mediumtext';

unset($TCA['tx_zora_domain_model_zora']['columns']['zora_query_type']);
$TCA['tx_zora_domain_model_zora']['columns']['zora_query_type'] = array(
	'exclude' => 0,
	'label' => 'LLL:EXT:zora/Resources/Private/Language/locallang_db.xml:tx_zora_domain_model_zora.zora_query_type',
	'config' => array(
		'type' => 'select',
		'items' => array(
			array('LLL:EXT:zora/Resources/Private/Language/locallang_ZoraFlexForm.xml:zoraFlexFormBE.generalQueryTypeSavedSearch', 0),
			array('LLL:EXT:zora/Resources/Private/Language/locallang_ZoraFlexForm.xml:zoraFlexFormBE.generalQueryTypeAdvancedSearch', 1),
		),
	),
);

$TCA ['tx_zora_domain_model_zora']['types'] = array (
		'0' => array('showitem' => 'title, last_update, zora_query_type, flex_form'), 
		'1' => array('showitem' => 'title, last_update, zora_query_type, flex_form') 
)
?>