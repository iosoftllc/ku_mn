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
			echo "alert(\"작업수행 중 오류가 발생하였습니다.\\n\\n나중에 다시 시도해 주세요.\");";
			echo "history.go(-1);";
			echo "</script>";
		} else if ($mode == "no_pw") {
			echo "<script language=\"javascript\">";
			echo "alert(\"현재 사용중인 비밀번호가 일치하지 않습니다.\");";
			echo "history.go(-1);";
			echo "</script>";
		} else if ($mode == "pw") {
			echo "<script language=\"javascript\">";
			echo "alert(\"관리자 비밀번호 변경이 정상적으로 처리 되었습니다.\\n\\n다시 로그인 하시기 바랍니다.\");";
			echo "document.location.replace(\"../../src/main/logout.php\");";
			echo "</script>";
		} else if ($mode == "edit") {
			echo "<script language=\"javascript\">";
			echo "alert(\"관리자정보를 성공적으로 수정하였습니다.\");";
			echo "document.location.replace(\"check_pw.php\");";
			echo "</script>";
		} else header("Location: check_pw.php");
	}
?>