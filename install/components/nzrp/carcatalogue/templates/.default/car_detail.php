<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

/** @var $arResult */
/** @var CBitrixComponent $component */
/** @var  $APPLICATION */

$APPLICATION->IncludeComponent(
	"nzrp:carcatalogue.details",
	"",
	[
		'CAR_ID'=>$arResult['VARIABLES']['CAR'],
		'FOLDER'=>$arResult['FOLDER']
	],
	$component
);