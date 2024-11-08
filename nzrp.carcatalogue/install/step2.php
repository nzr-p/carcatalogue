<?php
/** @global CMain $APPLICATION */
if (!check_bitrix_sessid())
	return;
use Bitrix\Main\UI\Extension;
Extension::load('ui.bootstrap4');

if ($ex = $APPLICATION->GetException())
	CAdminMessage::ShowMessage(array(
		"TYPE" => "ERROR",
		"MESSAGE" => GetMessage("MOD_INST_ERR"),
		"DETAILS" => $ex->GetString(),
		"HTML" => true,
	));
else
	CAdminMessage::ShowNote(GetMessage("MOD_INST_OK"));
?>
<form action="<?php echo $APPLICATION->GetCurPage(); ?>">
	<input type="submit" name="" value="<?php echo GetMessage("MOD_BACK"); ?>">
<form>