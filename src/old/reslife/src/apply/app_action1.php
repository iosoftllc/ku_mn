<?
	include_once("../common/login_tpl.php");
	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 0 && (int)$ihouse_admin_info[grade] != 1 && (int)$ihouse_admin_info[grade] != 2 && (int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/application_tpl.php");

			switch ($mode) {
				case "approval_y":
					if ($ihouse_admin_info[grade] == "9" || $ihouse_admin_info[grade] == "8" || $ihouse_admin_info[grade] == "2" || $ihouse_admin_info[grade] == "1" || $ihouse_admin_info[grade] == "0") {
						$flag = $application->approveApplication($no, $ihouse_admin_info[grade], "Y");
						$msg = $application->errorMessage;
						if (!$flag) $mode = "error";
					} else $mode = "no_auth";
					break;
				case "approval_n":
					if ($ihouse_admin_info[grade] == "9" || $ihouse_admin_info[grade] == "8" || $ihouse_admin_info[grade] == "2" || $ihouse_admin_info[grade] == "1" || $ihouse_admin_info[grade] == "0") {
						$flag = $application->approveApplication($no, $ihouse_admin_info[grade], "N");
						$msg = $application->errorMessage;
						if (!$flag) $mode = "error";
					} else $mode = "no_auth";
					break;
			}

			$application->closeDatabase();
			unset($application);

			if ($mode == "error") {
				echo "<script language=\"javascript\">";
				echo "alert(\"작업수행 중 오류가 발생하였습니다.\\n\\n나중에 다시 시도해 주세요.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "no_auth") {
				echo "<script language=\"javascript\">";
				echo "alert(\"결재에 관한 권한이 없습니다.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "approval_y" || $mode == "approval_n") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"$msg\");";
				echo "document.location.replace(\"app_view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_kind=$s_kind&s_rate=$s_rate&s_state=$s_state&s_grade=$s_grade&s_current=$s_current&s_period=$s_period&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2\");";
				echo "</script>";
			} else header("Location: app_list.php");
		}
	}
?>