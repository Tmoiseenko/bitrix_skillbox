<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock'))
	return;

$arTypes = CIBlockParameters::GetIBlockTypes(['-' => ' ']);

$arIBlocks = [];
if (
	isset($arCurrentValues['IBLOCK_TYPE'])
	&& trim($arCurrentValues['IBLOCK_TYPE'])
	&& trim($arCurrentValues['IBLOCK_TYPE']) != '-'
) {
	$rsIBlocks = CIBlock::GetList(
		['SORT' => 'ASC'],
		['SITE_ID' => $_REQUEST['site'], 'TYPE' => trim($arCurrentValues['IBLOCK_TYPE'])]
	);
	while ($arIBlock = $rsIBlocks->Fetch()) {
		$arIBlocks[$arIBlock['ID']] = '[' . $arIBlock['ID'] . '] ' . $arIBlock['NAME'];
	}
}

$arSections = [];
if (
	isset($arCurrentValues['IBLOCK_ID'])
	&& intval($arCurrentValues['IBLOCK_ID']) > 0
) {
	$rsSections = CIBlockSection::GetList(
		[],
		['IBLOCK_ID' => intval($arCurrentValues['IBLOCK_ID'])]
	);
	while ($arSection = $rsSections->Fetch()) {
		$arSections[$arSection['ID']] = '[' . $arSection['ID'] . '] ' . $arSection['NAME'];
	}
}

$arComponentParameters = [
	'GROUPS' => [
	],
	'PARAMETERS' => [
		'CACHE_TIME' => [
			'DEFAULT' => '3600'
		],
		'IBLOCK_TYPE' => [
			'PARENT' => 'BASE',
			'NAME' => 'Тип инфоблока',
			'TYPE' => 'LIST',
			'VALUES' => $arTypes,
			'DEFAULT' => '',
			'REFRESH' => 'Y'
		],
		'IBLOCK_ID' => [
			'PARENT' => 'BASE',
			'NAME' => 'Инфоблок',
			'TYPE' => 'LIST',
			'VALUES' => $arIBlocks,
			'DEFAULT' => '',
			'ADDITIONAL_VALUES' => 'Y',
			'REFRESH' => 'Y'
		],
		'SECTION_ID' => [
			'PARENT' => 'BASE',
			'NAME' => 'Раздел инфоблока',
			'TYPE' => 'LIST',
			'VALUES' => $arSections,
			'DEFAULT' => '',
			'ADDITIONAL_VALUES' => 'Y',
			'REFRESH' => 'Y'
		],
		'COUNT' => [
			'PARENT' => 'BASE',
			'NAME' => 'Количество',
			'TYPE' => 'STRING',
			'DEFAULT' => '1'
		]
	]
];