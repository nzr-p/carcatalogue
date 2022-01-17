<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;
use Bitrix\Main\Web\Json;
use Nzrp\CarCatalogue\Model\BrandTable;
use Nzrp\CarCatalogue\Model\ModelTable;

/** @var CBitrixComponent $component */
/** @var  $APPLICATION */
/** @var  $arResult */

$APPLICATION->IncludeComponent(
	"nzrp:carcatalogue.list",
	"",
	[
		'BRAND_ID'=>$arResult['VARIABLES']['BRAND']
	],
	$component
);
