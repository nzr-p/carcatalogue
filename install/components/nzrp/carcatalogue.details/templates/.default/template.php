<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Web\Json;
use Bitrix\Main\Localization\Loc;
use Bitrix\B24Connector\Connection;
use Nzrp\CarCatalogue\CarTable;
use Bitrix\Main\UI\Extension;

/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global $APPLICATION */

Extension::load('ui.bootstrap4');

$car=CarTable::getById($arParams['CAR_ID'])->fetchObject();
$carOptions=[];
$car->fillOptions();
foreach($car->getOptions() as $option) {
	$carOptions[]=$option->getName();
}

$complectOptions=[];

$complect=$car->fillComplect();
$complect->fillOptions();
foreach($complect->getOptions() as $option) {
	$complectOptions[]=$option->getName();
}

$model=$complect->fillModel();
$brand=$model->fillBrand();


$folder=rtrim($arParams['FOLDER'],'/');

$APPLICATION->AddChainItem("Каталог автомобилей", "$folder/");
$APPLICATION->AddChainItem($brand->getName(), "$folder/{$brand->getId()}/");
$APPLICATION->AddChainItem($model->getName(), "$folder/{$brand->getId()}/{$model->getId()}/");
$APPLICATION->AddChainItem($complect->getName(), "$folder/{$brand->getId()}/{$model->getId()}/{$complect->getId()}/");
$APPLICATION->AddChainItem($car->getName(), "");
$APPLICATION->SetTitle("Сведения об автомобиле ".$car->getName());



$rows=[
	["ID",$car->getId()],
	["Название",$car->getName()],
	["Комплект",$complect->getName()],
	["Год",$car->getYear()],
	["Цена",$car->getPrice()],//CCurrencyLang::CurrencyFormat($arResult['price'],"RUB")],
	["Опции автомобиля",implode(", ",$carOptions)],
	["Опции комплектации",implode(", ",$complectOptions)],
];

// если что я сделал на бутстрапе, но я реально не верстальщик
foreach($rows as $key=>$r) {
	echo "<dl class='row'>
	<dt class='col-sm-2'>$r[0]</dt><dl class='col-sm-9'>$r[1]</dl>
	</dl>";
}
