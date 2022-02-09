<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		$page_name = "비밀번호확인";
		$on_load = "document.PasswordForm.pw.focus();";

		include_once("../common/header_tpl.php");

		include_once("../common/footer_tpl.php");
	}
?>