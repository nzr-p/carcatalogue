<?php
/** @global CMain $APPLICATION */
if (!check_bitrix_sessid())
	return;
?>
<form action="<?php echo $APPLICATION->GetCurPage()?>" name="form1">
		<?=bitrix_sessid_post()?>
		<input type="hidden" name="id" value="nzrp.carcatalogue">
		<input type="hidden" name="uninstall" value="Y">
		<input type="hidden" name="step" value="2">

		<input type="checkbox" name="droptables" value="1" id=droptables>
		<label for=droptables>Удалить таблицы</label>
	<br><br>
		<input type="submit" name="inst" value="<?php echo GetMessage("MOD_UNINST_DEL")?>">
</form>