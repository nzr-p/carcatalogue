<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
	die();

use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Type\Date;
use Bitrix\Main\Loader;
use Nzrp\CarCatalogue\Model\CarTable;

class NzrpCarCatalogueList extends CBitrixComponent
{
	protected $errors = array();

	protected function prepareResult()
	{
	
	}

	protected function checkParams():bool
	{
//		if (empty($this->arParams['CAR_ID'])) {
//			$this->errors[]="Пустой параметр CAR_ID";
//			return false;
//		};
		
		return true;
	}
	
	public function executeComponent()
	{
//		global $APPLICATION;

		if (!$this->checkModules())
		{
			$this->showErrors();
			return;
		}

		if (!$this->checkParams())
		{
			$this->showErrors();
			return;
		}

//		$moduleAccess = $APPLICATION->GetGroupRight('b24connector');
//
//		if($moduleAccess < "R")
//		{
//			ShowError(Loc::getMessage('CRM_PERMISSION_DENIED'));
//			return;
//		}

//		$this->arResult['PERM_CAN_EDIT'] = ($moduleAccess > "R");

		$this->prepareResult();
		$this->includeComponentTemplate();
	}

	protected function checkModules():bool
	{
		$errors = array();

		if(!Loader::includeModule('nzrp.carcatalogue'))
			$errors[] = "Не установлен модуль nzrp.carcatalogue";
//		if(!Loader::includeModule('currency'))
//			$errors[] = "Не установлен модуль currency";

		if(!empty($errors))
			$this->errors = array_merge($this->errors, $errors);

		return empty($errors);
	}

	protected function showErrors()
	{
		if(count($this->errors) <= 0)
			return;

		foreach($this->errors as $error)
			ShowError($error);
	}

}