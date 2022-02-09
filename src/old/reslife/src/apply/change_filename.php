<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 7 && (int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/student_tpl.php");

			$dir = "../../../upload/temp";
			$lord = @opendir($dir);
			while ($info = @readdir($lord)) {
				if ($info != "." && $info != "..") {
					//$temp = explode(".", $info);
					//$no = trim($student->getStudentNumber($temp[0]));
					//if ($no != "") {
						$flag = false;
						$old = $dir . "/" . $info;
						$new = $dir . "/" . $info . ".jpg";
						if (file_exists("$old")) {
							$flag = rename($old, $new);
						}
						if ($flag) echo "$old - 성공<br>";
						else echo "$old - 실패<br>";
					//}
				}
			}
			closedir($lord);

			$student->closeDatabase();
			unset($student);

		}
	}
?>