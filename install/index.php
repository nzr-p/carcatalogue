<?php

use Bitrix\Main\Application;
use Bitrix\Main\Context;
use Bitrix\Main\ModuleManager;
use Nzrp\CarCatalogue\BrandTable;
use Nzrp\CarCatalogue\ComplectTable;
use Nzrp\CarCatalogue\ModelTable;

class nzrp_carcatalogue extends CModule
{
	public $MODULE_ID = "nzrp.carcatalogue";
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME = "Каталог автомобилей";
	public $MODULE_DESCRIPTION = "модуль по заданию";
	public $MODULE_CSS;
	
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
				// не знаю, можно ли так, но работает
				// это нужно чтобы получить список таблиц
				CModule::IncludeModule($this->MODULE_ID);
				
				$request=Context::getCurrent()->getRequest();
				if($request->get("droptables")) {
					$this->UnInstallDB();
				}
				//	$this->InstallDB();
			} catch(Error $ex) {
				ModuleManager::unRegisterModule($this->MODULE_ID);
				$APPLICATION->ThrowException("Во время установки произошла ошибка");
			}
			$APPLICATION->ThrowException("Во время установки произошла ошибка");

			
			
			//		CopyDirFiles(
//			$this->dir."/install/components",
//			$_SERVER["DOCUMENT_ROOT"]."/bitrix/components",
//			true,
//			true
//		);

//		ModuleManager::registerModule($this->MODULE_ID);
			$APPLICATION->IncludeAdminFile("Установка модуля \"$this->MODULE_NAME\"", __DIR__."/step2.php");
		}
	}
	
	public function doUninstall()
	{
		global $APPLICATION,$step;
		
		$step=intval($step);
		if ($step<2) {
			$APPLICATION->IncludeAdminFile("Удаление модуля \"$this->MODULE_NAME\"", __DIR__."/step1.php");
		}
		elseif($step==2) {
			ModuleManager::registerModule($this->MODULE_ID);
			try {
				CModule::IncludeModule($this->MODULE_ID);
				
				$request=Context::getCurrent()->getRequest();
				if($request->get("droptables")) {
					$this->UnInstallDB();
				}
			} catch(Error $ex) {
				$APPLICATION->ThrowException("Во время удаления произошла ошибка");
			}
			ModuleManager::unRegisterModule($this->MODULE_ID);
			$APPLICATION->IncludeAdminFile("Удаление модуля \"$this->MODULE_NAME\"", __DIR__."/step2.php");
		}




//		DeleteDirFilesEx("/local/components/".$this->MODULE_ID);
		
		ModuleManager::unRegisterModule($this->MODULE_ID);
//		echo CAdminMessage::ShowMessage(array("MESSAGE"=>"Модуль $this->MODULE_ID удалён", "TYPE"=>"OK"));
//		echo "asdfasdfdsf";
		
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

//
//		$newBook = new EO_Brand();
//		$newBook->setName('Brand1');
//		$newBook->save();
	}
	public function UnInstallDB() {
		$con = Application::getConnection();
		
		foreach($this->getTables() as $table) {
			if ($con->isTableExists($table->getDBTableName())) {
				$con->dropTable($table->getDBTableName());
			}
		}
	}
	/**
	 * @return \Bitrix\Main\ORM\Entity[]
	 */
	private function getTables():array {
		return [
			BrandTable::getEntity(),
			ModelTable::getEntity(),
			ComplectTable::getEntity(),
		];
	}
}