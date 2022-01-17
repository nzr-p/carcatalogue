<?php
/** @global CMain $APPLICATION */
if (!check_bitrix_sessid())
	return;
use Bitrix\Main\UI\Extension;
Extension::load('ui.bootstrap4');
?>
<form action="<?php echo $APPLICATION->GetCurPage()?>" name="form1">
		<?=bitrix_sessid_post()?>
		<input type="hidden" name="id" value="nzrp.carcatalogue">
		<input type="hidden" name="uninstall" value="Y">
		<input type="hidden" name="step" value="2">

		<input type="checkbox" name="droptables" value="1" id=droptables>
		<label for=droptables>Удалить таблицы <span class="glyphicon glyphicon-trash"></span></label>
	<br><br>
		<input type="submit" class="btn btn-primary" name="inst" value="<?php echo GetMessage("MOD_UNINST_DEL")?>">
</form>