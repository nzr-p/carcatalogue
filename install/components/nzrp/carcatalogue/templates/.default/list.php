<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

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