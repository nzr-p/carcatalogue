<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Web\Json;
use Nzrp\CarCatalogue\Model\CarTable;

/** @var $arResult */

$carId=$arResult['VARIABLES']['id'];
$r=CarTable::getRow([
	'select'=>[
		"ID",
		"NAME",
		"COMPLECT_ID",
		"MODEL_ID"=>"COMPLECT.MODEL.ID",
		"BRAND_ID"=>"COMPLECT.MODEL.BRAND.ID",
		"YEAR",
		"PRICE"
	],
	'filter'=>['=ID'=>$carId]
]);


echo Json::encode($r);