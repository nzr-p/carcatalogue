<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;
use Bitrix\Main\Web\Json;
use Nzrp\CarCatalogue\BrandTable;

$res=BrandTable::getList([
	'select'=>['ID','NAME'],
]);

$rows=$res->fetchAll();

echo Json::encode($rows);