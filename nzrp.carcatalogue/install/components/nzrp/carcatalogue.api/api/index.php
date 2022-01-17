<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
header("Content-type: application/json; charset=utf-8");

/** @global $APPLICATION */
$APPLICATION->IncludeComponent(
	"nzrp:carcatalogue.api",
	""
);