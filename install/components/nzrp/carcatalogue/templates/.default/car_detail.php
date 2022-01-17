<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;
use Bitrix\Main\Web\Json;
use Nzrp\CarCatalogue\Model\CarTable;

/** @var $arResult */

/** @var CBitrixComponent $component */
/** @var  $APPLICATION */
/** @var  $arResult */

$APPLICATION->IncludeComponent(
	"nzrp:carcatalogue.details",
	"",
	[
		'CAR_ID'=>$arResult['VARIABLES']['CAR'],
		'FOLDER'=>$arResult['FOLDER']
	],
	$component
);