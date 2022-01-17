<?php
$module_id = 'nzrp.carcatalogue';

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\B24Connector\Connection;

/**
 * @global CUser $USER
 * @global CMain $APPLICATION
 **/


$moduleAccess = $APPLICATION->GetGroupRight($module_id);

if($moduleAccess >= "W"):
	
	Loader::includeModule($module_id);
	IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/options.php");
	
	$aTabs = array(
		array("DIV" => "edit2", "TAB" => Loc::getMessage("MAIN_TAB_RIGHTS"), "ICON" => "", "TITLE" => Loc::getMessage("MAIN_TAB_TITLE_RIGHTS"))
	);
	
	$tabControl = new CAdminTabControl("tabControl", $aTabs);
	
	if($_SERVER["REQUEST_METHOD"] == "POST" && $_REQUEST["Update"] != "" && check_bitrix_sessid())
	{
		if(isset($_REQUEST["disconnect"]) && $_REQUEST["disconnect"] == 'Y')
			Connection::delete();
		
		ob_start();
		require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");
		ob_end_clean();
		
		if($_REQUEST["back_url_settings"] <> '')
			LocalRedirect($_REQUEST["back_url_settings"]);
		
		LocalRedirect($APPLICATION->GetCurPage()."?mid=".urlencode($module_id)."&lang=".urlencode(LANGUAGE_ID)."&".$tabControl->ActiveTabParam());
	}
	
	$tabControl->Begin();
	?>
	<form method="post" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=urlencode($module_id)?>&amp;lang=<?=LANGUAGE_ID?>">
		<?$tabControl->BeginNextTab();?>
		<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");?>
		
		<?$tabControl->Buttons();?>
		<input type="submit" name="Update" value="<?=GetMessage("MAIN_SAVE")?>" title="<?=GetMessage("MAIN_OPT_SAVE_TITLE")?>" class="adm-btn-save">
		<?=bitrix_sessid_post();?>
		<?if($_REQUEST["back_url_settings"] <> ''):?>
			<input type="button" name="Cancel" value="<?=GetMessage("MAIN_OPT_CANCEL")?>" onclick="window.location='<?echo htmlspecialcharsbx(CUtil::addslashes($_REQUEST["back_url_settings"]))?>'">
			<input type="hidden" name="back_url_settings" value="<?=htmlspecialcharsbx($_REQUEST["back_url_settings"])?>">
		<?endif;?>
		<?$tabControl->End();?>
	</form>

<?endif;?>