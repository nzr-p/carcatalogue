<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Iblock\Component\Tools;
/** @var array $arParams */

$arVariables = [];
$arVariableAliases=[];

$arComponentVariables = array(
//	'brand',
//	'model',
//	'comp'
);

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

/*
 * Добавим в $arVariables переменные из $_REQUEST, которые есть в $arComponentVariables и в $arVariableAliases.
 * Переменные из $arComponentVariables просто добавляются в $arVariables, если они есть в $_REQUEST. Переменные
 * $arVariableAliases добавляютcя под своими реальными именами, если в $_REQUEST есть соответствующий псевдоним.
 * В итоге, для страницы
 * server.com/demo/category/id/28/?show=3&sort=date&dir=desc
 * получим такой массив
 * $arVariables = Array (
 *    [SECTION_ID] => 28
 *    [ELEMENT_COUNT] => 3
 *    [sort] => date
 *    [dir] => desc
 * )
 */
CComponentEngine::InitComponentVariables(
	$componentPage,
	$arComponentVariables,
	$arVariableAliases,
	$arVariables
);

$arResult['VARIABLES'] = $arVariables;
$arResult['FOLDER'] = $arParams['SEF_FOLDER'];
$arResult['PAGE'] = $componentPage;

//echo "<pre>".var_export($arResult,true)."</pre><br>";

if ($componentPage!=='car_detail') {
	$componentPage='list';
}

$this->IncludeComponentTemplate($componentPage);
