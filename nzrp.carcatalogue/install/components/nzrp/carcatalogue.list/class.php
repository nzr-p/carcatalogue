<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
	die();

use Bitrix\Main\Loader;

class NzrpCarCatalogueList extends CBitrixComponent
{
	protected $errors = array();

	protected function prepareResult()
	{
	
	}

	public function executeComponent()
	{

		if (!$this->checkModules())
		{
			$this->showErrors();
			return;
		}
		
		if (CMain::GetGroupRight("nzrp.carcatalogue")<"W") {
			ShowError("Нет доступа");
			return;
		}

		$this->prepareResult();
		$this->includeComponentTemplate();
	}

	protected function checkModules():bool
	{
		$errors = array();

		if(!Loader::includeModule('nzrp.carcatalogue'))
			$errors[] = "Не установлен модуль nzrp.carcatalogue";

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