<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Context;
use Bitrix\Main\Loader;

$arParams["SEF_FOLDER"] = "/api/";

$arVariables = [];
$arVariableAliases=[];

$arComponentVariables = array(
	'brand',
	'model',
	'comp'
);

$arDefaultUrlTemplates404 = array(
	'brands' => 'brands',
	'models' => 'models',
	'comps' => 'comps',
	'cars' => 'cars',
	'car_id' => 'cars/#id#',
);

/** @var array $arParams */
$arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates(
	$arDefaultUrlTemplates404,
	$arParams['SEF_URL_TEMPLATES']
);

$componentPage = CComponentEngine::ParseComponentPath(
	$arParams['SEF_FOLDER'],
	$arUrlTemplates,
	$arVariables
);

$request=Context::getCurrent()->getRequest();

if (
	// всё что не get не обрабатываем
	$request->getRequestMethod()!=='GET'
	|| empty($componentPage)
	|| !Loader::includeModule("nzrp.carcatalogue")
) {
	CHTTP::setStatus("404 Not Found");
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

//echo "<pre>".var_export($arResult,true)."</pre><br>";


$this->IncludeComponentTemplate($componentPage);
