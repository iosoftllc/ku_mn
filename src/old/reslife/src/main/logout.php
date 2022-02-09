<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../common/admin_tpl.php");
		$admin->logout($ihouse_admin_info[id], $_SERVER["REMOTE_ADDR"]);
		$admin->closeDatabase();
		unset($admin);
	}
		
	session_unregister("ihouse_admin_info");
	session_destroy();

	echo "<script language=\"javascript\">";
	echo "window.top.location.replace(\"../../\");";
	echo "</script>";
?>