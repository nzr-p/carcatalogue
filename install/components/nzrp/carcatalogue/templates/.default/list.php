<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;
use Bitrix\Main\Web\Json;
use Nzrp\CarCatalogue\BrandTable;

/** @var CBitrixComponent $component */
/** @var  $APPLICATION */
/** @var  $arResult */

$params=$arResult['VARIABLES'];
$params['FOLDER']=$arResult['FOLDER'];

$APPLICATION->IncludeComponent(
	"nzrp:carcatalogue.list",
	"",
	$params,
	$component
);