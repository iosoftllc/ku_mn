<?
  include_once("../../lib/conf.common.php");
	include_once("../common/admin_tpl.php");

	$admin_id = $_POST["ihouse_adminid"];
	$admin_pw = $_POST["ihouse_adminpw"];
	if (!$admin->isExist($admin_id)) {
		$admin->closeDatabase();
		unset($admin);
		echo "<script language=\"javascript\">";
		echo "alert(\"�Է��Ͻ� ���̵�� �����ڰ� �ƴմϴ�.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if (!$admin->checkPassword($admin_id, $admin_pw)) {
		$admin->closeDatabase();
		unset($admin);
		echo "<script LANGUAGE=\"JavaScript\">";
		echo "alert(\"�Է��Ͻ� ��й�ȣ�� ��ġ���� �ʽ��ϴ�.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else {
		$admin->getSessionInfo($admin_id);
		$ihouse_admin_info = array("log"        => "Y",
		                           "id"         => $admin_id,
		                           "grade"      => $admin->adminGrade,
		                           "name"       => $admin->adminName,
		                           "department" => $admin->adminDepartment,
		                           "email"      => $admin->adminEmail);
		$admin->login($admin_id, $_SERVER["REMOTE_ADDR"]);
		$admin->closeDatabase();
		unset($admin);
		session_start();
		session_register("ihouse_admin_info");
		header("Location: main.php");
	}
?>