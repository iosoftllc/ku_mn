<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../common/admin_tpl.php");
		
		switch ($mode) {
			case "edit":
				$admin_nm = $_POST["admin_nm"];
				$department = $_POST["department"];
				$email = $_POST["email"];
				$admin_nm = htmlspecialchars($admin_nm);
				$department = htmlspecialchars($department);
				$email = htmlspecialchars($email);
				$admin_name = addslashes($admin_nm);
				$department = addslashes($department);
				$admin_email = addslashes($email);
				$flag = $admin->updateAdmin($ihouse_admin_info[id], $admin_name, $department, $admin_email);
				if ($flag) {
					$ihouse_admin_info[name] = $admin_nm;
					$ihouse_admin_info[department] = $department;
					$ihouse_admin_info[email] = $email;
				} else $mode = "error";
				break;
			case "pw":
				$cur_pw = $_POST["cur_pw"];
				$flag = $admin->checkPassword($ihouse_admin_info[id], $cur_pw);
				if ($flag) {
					$new_pw = $_POST["new_pw"];
					$flag = $admin->updatePassword($ihouse_admin_info[id], $new_pw);
					if (!$flag) $mode = "error";
				} else $mode = "no_pw";
				break;
		}
		$admin->closeDatabase();
		unset($admin);
		
		if ($mode == "error") {
			echo "<script language=\"javascript\">";
			echo "alert(\"�۾����� �� ������ �߻��Ͽ����ϴ�.\\n\\n���߿� �ٽ� �õ��� �ּ���.\");";
			echo "history.go(-1);";
			echo "</script>";
		} else if ($mode == "no_pw") {
			echo "<script language=\"javascript\">";
			echo "alert(\"���� ������� ��й�ȣ�� ��ġ���� �ʽ��ϴ�.\");";
			echo "history.go(-1);";
			echo "</script>";
		} else if ($mode == "pw") {
			echo "<script language=\"javascript\">";
			echo "alert(\"������ ��й�ȣ ������ ���������� ó�� �Ǿ����ϴ�.\\n\\n�ٽ� �α��� �Ͻñ� �ٶ��ϴ�.\");";
			echo "document.location.replace(\"../../src/main/logout.php\");";
			echo "</script>";
		} else if ($mode == "edit") {
			echo "<script language=\"javascript\">";
			echo "alert(\"������������ ���������� �����Ͽ����ϴ�.\");";
			echo "document.location.replace(\"check_pw.php\");";
			echo "</script>";
		} else header("Location: check_pw.php");
	}
?>