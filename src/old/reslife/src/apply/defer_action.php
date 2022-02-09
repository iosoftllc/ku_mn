<?
	include_once("../common/login_tpl.php");
	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/defer_tpl.php");

			switch ($mode) {
				case "new":
					$apply_no = $_POST["apply_no"];
					if ($defer->isDeferExist($apply_no)) $mode = "apply";
					else {
						$approve = $_POST["approve"];
						$exchange = $_POST["exchange"];
						$grant = $_POST["grant"];
						$admin = $_POST["admin"];
						$admin = addslashes($admin);
						$admin = htmlspecialchars($admin);
						if ($approve != "Y" && $approve != "C") $approve = "N";
						if ($exchange != "KUSEP" && $exchange != "KIEP" && $exchange != "ISEP") $exchange = "";
						if ($grant == "") $grant = "0000-00-00";
						if ($approve == "N" || $approve == "C") $grant = "0000-00-00";
						$flag = $defer->insertDefer($apply_no, $approve, $exchange, $grant, $admin);
						if ($flag) {
							if ($approve == "Y") $flag = $defer->approveDefer($defer->deferNumber, $grant, $ihouse_admin_info[grade]);
						} else $mode = "error";
					}
					break;
				case "edit":
					$apply_no = $_POST["apply_no"];
					if ($defer->isDeferExist($apply_no) && $no != $defer->deferNumber) $mode = "apply";
					else {
						$approve = $_POST["approve"];
						$exchange = $_POST["exchange"];
						$grant = $_POST["grant"];
						$admin = $_POST["admin"];
						$admin = addslashes($admin);
						$admin = htmlspecialchars($admin);
						if ($approve != "Y" && $approve != "C") $approve = "N";
						if ($exchange != "KUSEP" && $exchange != "KIEP" && $exchange != "ISEP") $exchange = "";
						if ($grant == "") $grant = "0000-00-00";
						if ($approve == "N" || $approve == "C") $grant = "0000-00-00";
						$flag = $defer->updateDefer($no, $apply_no, $approve, $exchange, $grant, $admin);
						if ($flag) {
							if ($approve == "Y") $flag = $defer->approveDefer($no, $grant, $ihouse_admin_info[grade]);
						} else $mode = "error";
					}
					break;
				case "del":
					$arr_no = explode(",", $no);
					for ($i = 0; $i < count($arr_no); $i++) {
						$flag = $defer->deleteDefer($arr_no[$i]);
						if (!$flag) {
							$mode = "error";
							break;
						} 
					}
					break;
				case "approve":
					$arr_no = explode(",", $no);
					$grant = $_POST["grant"];
					if ($grant == "") $grant = "0000-00-00";
					for ($i = 0; $i < count($arr_no); $i++) {
						$flag = $defer->approveDefer($arr_no[$i], $grant, $ihouse_admin_info[grade]);
						if (!$flag) {
							$mode = "error";
							break;
						} 
					}
					break;
			}

			$defer->closeDatabase();
			unset($defer);

			if ($mode == "error") {
				echo "<script language=\"javascript\">";
				echo "alert(\"작업수행 중 오류가 발생하였습니다.\\n\\n나중에 다시 시도해 주세요.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "apply") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"" . $apply_no . "은(는) 이미 등록되어 있는 지원번호입니다.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "edit") header("Location: defer_view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_approve=$s_approve&s_period=$s_period&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2");
			else if ($mode == "del" || $mode == "approve") header("Location: defer_list.php?page=$page&s_type=$s_type&s_text=$s_text&s_approve=$s_approve&s_period=$s_period&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2");
			else header("Location: defer_list.php");
		}
	}
?>