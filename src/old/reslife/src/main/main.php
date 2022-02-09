<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		$html_file = "body";
		$page_name = "Ȩ";
		$on_load = "";

		include_once("../common/header_tpl.php");
		include_once("../common/admin_tpl.php");

		$admin->getLogInfo($ihouse_admin_info[id]);
		$tpl->assign(array(ADMIN_ID    => strtoupper($ihouse_admin_info[id]),
		                   ADMIN_NAME  => $ihouse_admin_info[name],
		                   LOGIN_TIME  => $admin->loginTime,
		                   LOGOUT_TIME => $admin->logoutTime,
		                   LOG_COUNT   => $admin->logCount,
		                   LOG_IP      => $admin->logIP));
		$admin->closeDatabase();
		unset($admin);

		include_once("../common/footer_tpl.php");
	}
?>