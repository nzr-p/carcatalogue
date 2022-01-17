<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;
use Bitrix\Main\Web\Json;
use Nzrp\CarCatalogue\Model\BrandTable;

/** @var CBitrixComponent $component */
/** @var  $APPLICATION */

$APPLICATION->IncludeComponent(
	"nzrp:carcatalogue.list",
	"",
	[],
	$component
);