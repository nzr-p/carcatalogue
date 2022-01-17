<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	'NAME' => "Каталог автомобилей",
	'DESCRIPTION' => "Просмотр каталога автомобилей",
	'SORT' => 20,
	'CACHE_PATH' => 'Y',
	'COMPLEX' => 'Y',
	'PATH' => [ // расположение компонента в визуальном редакторе
        'ID' => 'carcat',
        'NAME' => 'Каталог автомобилей',
	]
);