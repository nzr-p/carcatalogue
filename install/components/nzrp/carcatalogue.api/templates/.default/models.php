<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Web\Json;
use Nzrp\CarCatalogue\ModelTable;

$arFilter=[];

$brandId=$arResult['VARIABLES']['brand']??0;
if ($brandId) {
	$arFilter=['=BRAND_ID'=>$brandId];
}

$res=ModelTable::getList([
	'select'=>['ID','NAME'],
	'filter'=>$arFilter
]);

$rows=$res->fetchAll();

echo Json::encode($rows);