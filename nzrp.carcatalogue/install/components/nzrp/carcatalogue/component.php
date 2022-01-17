<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Iblock\Component\Tools;
/** @var array $arParams */

if (CMain::GetGroupRight("nzrp.carcatalogue")<"W") {
	ShowError("Нет доступа");
	return;
}


$arVariables = [];
$arVariableAliases=[];

$arComponentVariables = [];
$arDefaultUrlTemplates404 = array(
	'brands' => 'index.php',
	'models' => '#BRAND#/',
	// а тут проблема потому что car_detail и comps имеют одинаковый шаблон
	// но если car_detail стоит раньше, то он и пройдёт раньше
	// можно сделать 2 в одном или написать через резольвер
	// ... но зачем усложнять?
	'car_detail' => 'detail/#CAR#/',
	'comps' => '#BRAND#/#MODEL#/',
	'cars' => '#BRAND#/#MODEL#/#COMP#/',
);
// на самом деле или car_detail или list на всё остальное (внизу)


$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates(
	$arDefaultUrlTemplates404,
	$arParams['SEF_URL_TEMPLATES']
);

$componentPage =  CComponentEngine::parseComponentPath(
	$arParams['SEF_FOLDER'],
	$arUrlTemplates,
	$arVariables
);

if (empty($componentPage)) {
	if (CModule::IncludeModule('iblock')) {
		Tools::process404(
			'Не найдено',
			true,
			true,
			false,
			false
		);
	}
	return;
}

CComponentEngine::InitComponentVariables(
	$componentPage,
	$arComponentVariables,
	$arVariableAliases,
	$arVariables
);

$arResult['VARIABLES'] = $arVariables;
$arResult['FOLDER'] = $arParams['SEF_FOLDER'];
$arResult['PAGE'] = $componentPage;

if ($componentPage!=='car_detail') {
	$componentPage='list';
}

$this->IncludeComponentTemplate($componentPage);
