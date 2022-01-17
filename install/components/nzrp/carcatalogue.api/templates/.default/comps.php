<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;
use Bitrix\Main\Web\Json;
use Nzrp\CarCatalogue\BrandTable;
use Nzrp\CarCatalogue\ComplectTable;
use Nzrp\CarCatalogue\ModelTable;

$arFilter=[];

$modelId=$arResult['VARIABLES']['model']??0;
if ($modelId) {
	$arFilter=['=MODEL_ID'=>$modelId];
}

$res=ComplectTable::getList([
	'select'=>['ID','NAME'],
	'filter'=>$arFilter
]);

$rows=$res->fetchAll();


echo Json::encode($rows);