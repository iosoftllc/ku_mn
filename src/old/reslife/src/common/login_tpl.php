<?
	include_once("../../lib/conf.common.php");

	session_start();
	$log_flag = false;
	$ihouse_admin_info = $_SESSION["ihouse_admin_info"];
	if ($ihouse_admin_info[log] == "Y") $log_flag = true;
	else {
		session_unregister("ihouse_admin_info");
		session_destroy();
		echo "<script language=\"javascript\">";
		echo "alert(\"�α����� �ϼž߸� ��� ������ �������Դϴ�.\\n\\n���� �α����� �ϼ���.\");";
		echo "window.top.location.replace(\"../../\");";
		echo "</script>";
	}
?>