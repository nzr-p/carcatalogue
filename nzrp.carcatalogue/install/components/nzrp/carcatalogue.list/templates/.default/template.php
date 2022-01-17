<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

/** @global $APPLICATION */
use Bitrix\Main\Grid\Options as GridOptions;
use Bitrix\Main\UI\PageNavigation;
use Nzrp\CarCatalogue\ComplectTable;
use Nzrp\CarCatalogue\CarTable;
use Nzrp\CarCatalogue\BrandTable;
use Nzrp\CarCatalogue\ModelTable;

/** @var $arParams */

$listId = 'carcatalogue';

$grid_options = new GridOptions($listId);
$grid_options->deleteView('default');
$sort = $grid_options->GetSorting(['sort' => ['ID' => 'ASC'], 'vars' => ['by' => 'by', 'order' => 'order']]);


$nav_params = $grid_options->GetNavParams();

$nav = new PageNavigation($listId);
$nav->allowAllRecords(true)
	->setPageSize($nav_params['nPageSize'])
	->initFromUri();

$filter=[];

$brandId=$arParams['BRAND']??0;
$modelId=$arParams['MODEL']??0;
$complectId=$arParams['COMP']??0;
$folder=rtrim($arParams['FOLDER'],'/');

$columns = [
	['id' => 'ID', 'name' => 'ID', 'default' => true,'width'=>50],
	['id' => 'NAME', 'name' => 'Название', 'default' => true]
];



$APPLICATION->AddChainItem("Каталог автомобилей", $folder."/");

if ($complectId) {
	$r=ComplectTable::getRow([
		"select"=>[
			"COMPLECT_ID"=>"ID",
			"COMPLECT_NAME"=>"NAME",
			"MODEL_NAME"=>"MODEL.NAME",
			"MODEL_ID",
			"BRAND_ID"=> "MODEL.BRAND.ID",
			"BRAND_NAME"=>"MODEL.BRAND.NAME"
		],
		"filter"=>["=ID"=>$complectId]
	]);
	$APPLICATION->AddChainItem($r['BRAND_NAME'], "$folder/$r[BRAND_ID]/");
	$APPLICATION->AddChainItem($r['MODEL_NAME'], "$folder/$r[BRAND_ID]/$r[MODEL_ID]/");
	$APPLICATION->AddChainItem($r['COMPLECT_NAME'], "$folder/$r[BRAND_ID]/$r[MODEL_ID]/$r[COMPLECT_ID]/");
	$APPLICATION->SetTitle($APPLICATION->GetTitle()." - комплектация ".$r['COMPLECT_NAME']);
	
	$folder.="/detail";
	
	$query = CarTable::query();
	$query
		->addSelect("YEAR")
		->addSelect("PRICE")
		->addFilter('=COMPLECT.ID',$complectId)
		->addFilter('=COMPLECT.MODEL.ID',$modelId)
		->addFilter('=COMPLECT.MODEL.BRAND.ID',$brandId);
	
	$columns[]=['id' => 'YEAR', 'name' => 'Год выпуска', 'sort' => 'YEAR', 'default' => true];
	$columns[]=['id' => 'PRICE', 'name' => 'Цена', 'sort' => 'PRICE', 'default' => true];
}
elseif($modelId) {
	$r=ModelTable::getRow([
		"select"=>[
			"MODEL_ID"=>"ID",
			"MODEL_NAME"=>"NAME",
			"BRAND_ID",
			"BRAND_NAME"=>"BRAND.NAME"
		],
		"filter"=>["=ID"=>$modelId]
	]);
	$APPLICATION->AddChainItem($r['BRAND_NAME'], "$folder/$r[BRAND_ID]/");
	$APPLICATION->AddChainItem($r['MODEL_NAME'], "$folder/$r[BRAND_ID]/$r[MODEL_ID]/");
	$APPLICATION->SetTitle($APPLICATION->GetTitle()." - модель ".$r['MODEL_NAME']);
	
	
	$folder.="/$brandId/$modelId";

	$query = ComplectTable::query();
	
	$query
		->addFilter('=MODEL.ID',$modelId)
		->addFilter('=MODEL.BRAND.ID',$brandId);
}
elseif($brandId) {
	$r=BrandTable::getRow([
		"select"=>[
			"BRAND_ID"=>"ID",
			"BRAND_NAME"=>"NAME",
		],
		"filter"=>["=ID"=>$brandId]
	]);
	$APPLICATION->AddChainItem($r['BRAND_NAME'], "$folder/$r[BRAND_ID]/");
	$APPLICATION->SetTitle($APPLICATION->GetTitle()." - брэнд ".$r['BRAND_NAME']);
	
	$folder.="/$brandId";
	$query = ModelTable::query();
	
	$query->addFilter('=BRAND.ID',$brandId);
}
else {
	$query = BrandTable::query();
}


// полиморфизм в действии
$query
	->addSelect("ID")
	->addSelect("NAME")
	->setOffset($nav->getOffset())
	->setLimit($nav->getLimit())
	->setOrder($sort['sort']);

$res = $query->exec();

$totalRowsCount=$query->queryCountTotal();
$nav->setRecordCount($totalRowsCount);

$list=[];


foreach ($res->fetchAll() as $r) {
	$data=[
		"ID" =>$r['ID'],
		"NAME" => "<a href='$folder/$r[ID]/'>$r[NAME]</a>",
	];
	
	if (isset($r['YEAR'])) {
		$data['YEAR']=$r['YEAR'];
	}
	if (isset($r['PRICE'])) {
		$data['PRICE']=$r['PRICE'];
	}
	
	$list[] = [
		'data' => $data
	];
}

$APPLICATION->IncludeComponent('bitrix:main.ui.grid', '', [
	'GRID_ID' => $listId,
	'COLUMNS' => $columns,
	'ROWS' => $list,
	'SHOW_ROW_CHECKBOXES' => false,
	'NAV_OBJECT' => $nav,
	'TOTAL_ROWS_COUNT'=>$totalRowsCount,
	'AJAX_MODE' => 'Y',
	'AJAX_ID' => CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
	'PAGE_SIZES' =>  [
		['NAME' => '3', 'VALUE' => '3'],
		['NAME' => '5', 'VALUE' => '5'],
		['NAME' => '10', 'VALUE' => '10']
	],
	'AJAX_OPTION_JUMP'          => 'N',
	'SHOW_CHECK_ALL_CHECKBOXES' => false,
	'SHOW_ROW_ACTIONS_MENU'     => false,
	'SHOW_GRID_SETTINGS_MENU'   => false,
	'SHOW_NAVIGATION_PANEL'     => true,
	'SHOW_PAGINATION'           => true,
	'SHOW_SELECTED_COUNTER'     => false,
	'SHOW_TOTAL_COUNTER'        => true,
	'SHOW_PAGESIZE'             => true,
	'SHOW_ACTION_PANEL'         => true,
	'ALLOW_COLUMNS_SORT'        => true,
	'ALLOW_COLUMNS_RESIZE'      => false,
	// если это выключить, то будет багаться сортировка
	'ALLOW_HORIZONTAL_SCROLL'   => true,
	'ALLOW_SORT'                => true,
	'ALLOW_PIN_HEADER'          => false,
	'AJAX_OPTION_HISTORY'       => 'N'
]);
