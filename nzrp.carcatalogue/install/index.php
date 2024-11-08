<?php

use Bitrix\Main\Application;
use Bitrix\Main\Context;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\UrlRewriter;
use Nzrp\CarCatalogue\BrandTable;
use Nzrp\CarCatalogue\CarTable;
use Nzrp\CarCatalogue\ComplectTable;
use Nzrp\CarCatalogue\ModelTable;
use Nzrp\CarCatalogue\OptionTable;

class nzrp_carcatalogue extends CModule
{
	public $MODULE_ID = "nzrp.carcatalogue";
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME = "Каталог автомобилей";
	public $MODULE_DESCRIPTION = "модуль по заданию";
	public $MODULE_CSS;
	public $MODULE_GROUP_RIGHTS = "Y";
	function __construct()
	{
		$arModuleVersion = array();
		include __DIR__."/version.php";
		
		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
		{
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}
		
	}
	
	/** @noinspection PhpUnused Всё тут используется*/
	function GetModuleRightList():array
	{
		return [
			"reference_id" => ["W","D"],
			"reference" => [
				"[W] Доступ разрешён",
				"[D] Доступ запрещён",
			]];
	}
	
	public function doInstall()
	{
		
		global $APPLICATION,$step;
		
		$step=intval($step);
		if ($step<2) {
			$APPLICATION->IncludeAdminFile("Установка модуля \"$this->MODULE_NAME\"", __DIR__."/step1.php");
		}
		elseif($step==2) {
			ModuleManager::registerModule($this->MODULE_ID);
			try {
				// это нужно чтобы получить список таблиц
				CModule::IncludeModule($this->MODULE_ID);
				
				$request=Context::getCurrent()->getRequest();
				if($request->get("droptables")) {
					$this->UnInstallDB();
				}
				$this->InstallDB();
				$this->InstallFiles();
				
				// права по умолчанию - полный доступ
				COption::SetOptionString($this->MODULE_ID, "GROUP_DEFAULT_RIGHT","W");
				
			} catch(Exception $ex) {
				// не уверен, что надо снимать регистрацию модуля в случае ошибки
				$APPLICATION->ThrowException("Во время установки произошла ошибка: ".$ex->getMessage());
			}

			$APPLICATION->IncludeAdminFile("Установка модуля \"$this->MODULE_NAME\"", __DIR__."/step2.php");
		}
	}
	
	public function doUninstall()
	{
		global $APPLICATION,$step;
		
		$step=intval($step);
		if ($step<2) {
			$APPLICATION->IncludeAdminFile("Удаление модуля \"$this->MODULE_NAME\"", __DIR__."/unstep1.php");
		}
		elseif($step==2) {
			try {
				CModule::IncludeModule($this->MODULE_ID);
				
				$request=Context::getCurrent()->getRequest();
				if($request->get("droptables")) {
					$this->UnInstallDB();
				}
				// убираем следы при удалении
				COption::RemoveOption($this->MODULE_ID, "GROUP_DEFAULT_RIGHT");
				
			} catch(Exception $ex) {
				$APPLICATION->ThrowException("Во время удаления произошла ошибка: ".$ex->getMessage());
			}
			ModuleManager::unRegisterModule($this->MODULE_ID);
			$APPLICATION->IncludeAdminFile("Удаление модуля \"$this->MODULE_NAME\"", __DIR__."/unstep2.php");
		}

		ModuleManager::unRegisterModule($this->MODULE_ID);
	}
	
	public function InstallDB() {
		$con = Application::getConnection();
		
		$skipData=false;
		
		foreach($this->getTables() as $table) {
			if (!$con->isTableExists($table->getDBTableName())) {
				$table->createDbTable();
			}
			else {
				$skipData=true;
			}
		}
		
		// если хотя бы одна из таблиц уже существует, то считаем что все таблицы с данными существуют
		// а если что-то не так, то по этому поводу в задании ничего не написано
		if ($skipData) {
			return;
		}

		$this->createData();
	}
	public function UnInstallDB() {
		$con = Application::getConnection();
		
		foreach($this->getTables() as $table) {
			if ($con->isTableExists($table->getDBTableName())) {
				$con->dropTable($table->getDBTableName());
			}
		}
	}
	
	public function InstallFiles() {
		if (!CopyDirFiles(
			__DIR__."/components",
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/components",
			true,
			true
		)) {
			throw new Exception("Компоненты не скопировались");
		}
		
		// можно и компонент весь перекинуть, но разве так не лучше?
		if (!CopyDirFiles(
			__DIR__."/components/nzrp/carcatalogue.api/api",
			$_SERVER["DOCUMENT_ROOT"]."/api",
			true,
			true
		)) {
			throw new Exception("Не удалось создать /api");
		}
		UrlRewriter::add(SITE_ID,[
			'CONDITION' => '#^/api/#',
			'RULE' => '',
			'ID' => 'nzrp:carcatalogue.api',
			'PATH' => '/api/index.php',
			'SORT' => 100,
		]);
	}
	
	
	private function getTables():array {
		$oe=OptionTable::getEntity();
		
		return [
			BrandTable::getEntity(),
			ModelTable::getEntity(),
			ComplectTable::getEntity(),
			CarTable::getEntity(),
			$oe,
			// так получаем объекты таблиц множественных связей
			$oe->getField("CARS")->getMediatorEntity(),
			$oe->getField("COMPLECTS")->getMediatorEntity()
		];
	}
	private function createData() {
		$data=include __DIR__."/data.inc";
		// создаём опции, они ещё понадобятся
		$options=[];
		foreach($data['options'] as $name) {
			$opt=OptionTable::createObject();
			$opt->setName($name);
			$options[]=$opt;
		}
		
		// каждый раз набор одинаково формируется
		srand(1);
		
		foreach( $data['brands'] as $brandName => $modelList) {
			$brand=BrandTable::createObject();
			$brand->setName($brandName);
			$brand->save();
			foreach($modelList as $modelName => $complectList) {
				$model=ModelTable::createObject();
				$model->setName($modelName);
				$model->setBrand($brand);
				$model->save();
				
				foreach($complectList as $complectName => $carList) {
					$complect=ComplectTable::createObject();
					$complect->setName($complectName);
					$complect->setModel($model);
					$complect->save();
					
					// связываем случайным образом, а то вручную на таком количестве не делают
					// вполне годная модель получается
					foreach($options as $opt) {
						if (rand(0,1000)<500) {
							$opt->addToComplects($complect);
						}
					}
					
					foreach($carList as $r) {
						$car=CarTable::createObject();
						$car->setYear($r[0]);
						$car->setPrice($r[1]);
						$car->setName($model->getName()." ".$car->getYear()." ".mb_substr($complect->getName(),0,1));
						$car->setComplect($complect);
						$car->save();
						
						foreach($options as $opt) {
							if (rand(0,1000)<500) {
								$opt->addToCars($car);
							}
						}
						
					}
				}
			}
		}
		
		foreach($options as $opt) {
			$opt->save();
		}
		
	}
}