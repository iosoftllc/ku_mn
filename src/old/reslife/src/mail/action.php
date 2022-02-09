<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 9) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/admin_tpl.php");
			switch ($mode) {
				case "new":
					if ($admin->isExist($id)) $mode = "id_exist";
					else {
						$grade = $_POST["grade"];
						$pw = $_POST["pw"];
						$email = $_POST["email"];
						$name = htmlspecialchars(addslashes($_POST["name"]));
						$department = htmlspecialchars(addslashes($_POST["department"]));
						if (!is_numeric($grade)) $grade = 0;
						$flag = $admin->insertAdmin($id, $grade, $pw, $name, $department, $email);
						if (!$flag) $mode = "error";
					}
					break;
				case "edit":
					$grade = $_POST["grade"];
					$email = $_POST["email"];
					$name = htmlspecialchars(addslashes($_POST["name"]));
					$department = htmlspecialchars(addslashes($_POST["department"]));
					if (!is_numeric($grade)) $grade = 0;
					$flag = $admin->updateAdmin1($id, $grade, $name, $department, $email);
					if (!$flag) $mode = "error";
					break;
				case "del":
					$arr_id = explode(",", $id);
					for ($i = 0; $i < count($arr_id); $i++) {
						$flag = $admin->deleteAdmin($arr_id[$i]);
						if (!$flag) {
							$mode = "error";
							break;
						}
					}
					break;
				case "pw":
					$pw = $_POST["pw"];
					$flag = $admin->updatePassword($id, $pw);
					if (!$flag) $mode = "error";
					break;
			}
			$admin->closeDatabase();
			unset($admin);
			if ($mode == "error") {
				echo "<script language=\"javascript\">";
				echo "alert(\"�۾����� �� ������ �߻��Ͽ����ϴ�.\\n\\n���߿� �ٽ� �õ��� �ּ���.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "id_exist") {
				echo "<script language=\"javascript\">";
				echo "alert(\"". $id . "(��)�� �̹� ��ϵǾ� �ִ� ���̵��Դϴ�.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "pw") {
				echo "<script language=\"javascript\">";
				echo "alert(\"��й�ȣ ������ ���������� ó�� �Ǿ����ϴ�.\");";
				echo "document.location.replace(\"../../src/mail/view.php?id=$id&page=$page&s_type=$s_type&s_text=$s_text&s_grade=$s_grade&sort1=$sort1&sort2=$sort2\");";
				echo "</script>";
			} else if ($mode == "edit") header("Location: view.php?id=$id&page=$page&s_type=$s_type&s_text=$s_text&s_grade=$s_grade&sort1=$sort1&sort2=$sort2");
			else if ($mode == "del") header("Location: list.php?page=$page&s_type=$s_type&s_text=$s_text&s_grade=$s_grade&sort1=$sort1&sort2=$sort2");
			else header("Location: list.php");
		}
	}
?>