<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;
use Bitrix\Main\Web\Json;
use Nzrp\CarCatalogue\CarTable;

// отличается от остального, хотя можно и одинаково сделать
$query = CarTable::query();

// клеить в кучу фильтры особого смысла нет, но так код короче
$complectId=$arResult['VARIABLES']['comp']??0;
if ($complectId) {
	$query->addFilter('=COMPLECT.ID',$complectId);
}
$brandId=$arResult['VARIABLES']['brand']??0;
if ($brandId) {
	$query->addFilter('=COMPLECT.MODEL.BRAND.ID',$brandId);
}
$modelId=$arResult['VARIABLES']['model']??0;
if ($modelId) {
	$query->addFilter('=COMPLECT.MODEL.ID',$modelId);
}


$res=$query->setSelect(['ID','NAME'])->exec();

$rows=$res->fetchAll();

echo Json::encode($rows);