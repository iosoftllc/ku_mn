<?
	include_once("../common/login_tpl.php");
	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/room_old_tpl.php");
			
			switch ($mode) {
				case "edit":
					$phone = $_POST["phone"];
					$ip = $_POST["ip"];
					$flag = $room->updateRoom($code, $phone, $ip);
					if (!$flag) $mode = "error";
					break;
			}

			$room->closeDatabase();
			unset($room);
			
			if ($mode == "error") {
				echo "<script language=\"javascript\">";
				echo "alert(\"�۾����� �� ������ �߻��Ͽ����ϴ�.\\n\\n���߿� �ٽ� �õ��� �ּ���.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "edit") {
				echo "<script language=\"javascript\">";
				echo "alert(\"�������� �����Ǿ����ϴ�.\");";
				echo "document.location.replace(\"../../src/apply/room_old_list.php?page=$page&s_rate=$s_rate&s_type=$s_type&s_text=$s_text&sort1=$sort1&sort2=$sort2\");";
				echo "</script>";
			} else header("Location: room_old_list.php");
		}
	}
?>