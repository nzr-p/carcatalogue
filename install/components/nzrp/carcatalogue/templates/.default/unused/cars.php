<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;
use Bitrix\Main\Web\Json;
use Nzrp\CarCatalogue\Model\CarTable;

/** @var CBitrixComponent $component */
/** @var  $APPLICATION */
/** @var  $arResult */

$APPLICATION->IncludeComponent(
	"nzrp:carcatalogue.list",
	"",
	[
		'BRAND_ID'=>$arResult['VARIABLES']['BRAND'],
		'MODEL_ID'=>$arResult['VARIABLES']['MODEL'],
		'COMP_ID'=>$arResult['VARIABLES']['COMP']
	],
	$component
);
