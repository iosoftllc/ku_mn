<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../common/admin_tpl.php");

		$pw = $_POST["pw"];
		$flag = $admin->checkPassword($ihouse_admin_info[id], $pw);
		$admin->closeDatabase();
		unset($admin);
		if ($flag) {
			$page_name = "������ ��������";
			$on_load = "document.PasswordForm.cur_pw.focus();";

			include_once("../common/header_tpl.php");
	
			$tpl->assign(array(ADMIN_NAME       => $ihouse_admin_info[name],
			                   ADMIN_DEPARTMENT => $ihouse_admin_info[department],
			                   ADMIN_EMAIL      => $ihouse_admin_info[email]));
	
			include_once("../common/footer_tpl.php");
		} else {
			echo "<script language=\"javascript\">";
			echo "alert(\"��й�ȣ�� ��ġ���� �ʽ��ϴ�.\");";
			echo "history.go(-1);";
			echo "</script>";
		}
	}
?>