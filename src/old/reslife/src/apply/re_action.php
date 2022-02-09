<?
	include_once("../common/login_tpl.php");
	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/refund_tpl.php");
			switch ($mode) {
				case "new":
					$photo_name = $HTTP_POST_FILES['photo']['name'];
					$photo_size = $HTTP_POST_FILES['photo']['size'];
					$photo_type = $HTTP_POST_FILES['photo']['type'];
					$photo_tmp = $HTTP_POST_FILES['photo']['tmp_name'];
					if ($photo_size <= $max_attach) {
						$apply_no = $_POST["apply_no"];
						$cf_apply_no = $_POST["cf_apply_no"];
						$kind = $_POST["kind"];
						$student = $_POST["student"];
						$vacate_flag = $_POST["vacate_flag"];
						$method_type = $_POST["method_type"];
						$dorm = $_POST["dorm"];
						$room = $_POST["room"];
						$refund_flag = $_POST["refund_flag"];
						$old_period = $_POST["old_period"];
						$new_period = $_POST["new_period"];
						$reason = htmlspecialchars(addslashes($_POST["reason"]));
						$fname = htmlspecialchars(addslashes($_POST["fname"]));
						$mname = htmlspecialchars(addslashes($_POST["mname"]));
						$lname = htmlspecialchars(addslashes($_POST["lname"]));
						$email = htmlspecialchars(addslashes($_POST["email"]));
						$method_info1 = htmlspecialchars(addslashes($_POST["method_info1"]));
						$method_info2 = htmlspecialchars(addslashes($_POST["method_info2"]));
						$method_info3 = htmlspecialchars(addslashes($_POST["method_info3"]));
						$method_info4 = htmlspecialchars(addslashes($_POST["method_info4"]));
						$method_info5 = htmlspecialchars(addslashes($_POST["method_info5"]));
						$method_info6 = htmlspecialchars(addslashes($_POST["method_info6"]));
						$addr_line2 = htmlspecialchars(addslashes($_POST["addr_line2"]));
						$addr_line3 = htmlspecialchars(addslashes($_POST["addr_line3"]));
						$addr_city = htmlspecialchars(addslashes($_POST["addr_city"]));
						$addr_state = htmlspecialchars(addslashes($_POST["addr_state"]));
						$addr_postal = htmlspecialchars(addslashes($_POST["addr_postal"]));
						$addr_country = htmlspecialchars(addslashes($_POST["addr_country"]));
						$admin = htmlspecialchars(addslashes($_POST["admin"]));
						if ($kind != "L") $kind = "U";
						if ($vacate_flag != "Y") $vacate_flag = "N";
						if ($method_type != "M" && $method_type != "O") $method_type = "W";
						if ($dorm != "ANAM2" && $dorm != "ANAMG") $dorm = "IHOUSE";
						if ($refund_flag != "Y") $refund_flag = "N";
						if ($_POST["dob_yy"] && $_POST["dob_mm"] && $_POST["dob_dd"]) $dob = $_POST["dob_yy"] . "-" . $_POST["dob_mm"] . "-" . $_POST["dob_dd"];
						else $dob = "0000-00-00";
						if ($_POST["vacate_yy"] && $_POST["vacate_mm"] && $_POST["vacate_dd"]) $vacate = $_POST["vacate_yy"] . "-" . $_POST["vacate_mm"] . "-" . $_POST["vacate_dd"];
						else $vacate = "0000-00-00";
						if ($vacate_flag == "Y") $vacate = "0000-00-00";
						if ($refund_flag == "Y") {
							$cf_apply_no = 0;
							$new_period = "";
							if ($method_type == "M") {
								$method_info1 = $method_info4;
								$method_info2 = $method_info5;
								$method_info3 = $method_info6;
								$method_info4 = "";
								$method_info5 = "";
								$method_info6 = "";
							} else if ($method_type == "O") {
								$addr_city = "";
								$addr_state = "";
								$addr_postal = "";
							} else {
								$method_info4 = "";
								$method_info5 = "";
								$method_info6 = "";
								$addr_line2 = "";
								$addr_line3 = "";
								$addr_city = "";
								$addr_state = "";
								$addr_postal = "";
								$addr_country = "";
							}
						} else {
							$reason = "";
							$method_info1 = "";
							$method_info2 = "";
							$method_info3 = "";
							$method_info4 = "";
							$method_info5 = "";
							$method_info6 = "";
							$addr_line2 = "";
							$addr_line3 = "";
							$addr_city = "";
							$addr_state = "";
							$addr_postal = "";
							$addr_country = "";
						}
						if (!is_numeric($apply_no)) $apply_no = 0;
						if (!is_numeric($cf_apply_no)) $cf_apply_no = 0;
						$flag = $refund->insertRefund($apply_no, $cf_apply_no, $kind, $student, $fname, $mname, $lname, $dob, $email, $vacate, $reason, $method_type, $method_info1, $method_info2, $method_info3, $method_info4, $method_info5, $method_info6, $addr_line2, $addr_line3, $addr_city, $addr_state, $addr_postal, $addr_country, $dorm, $room, $old_period, $new_period, $admin);
						if ($flag) {
							if (is_uploaded_file($photo)) {
								$flag = move_uploaded_file($photo_tmp, $pht_dir."/".$refund->refundNumber.".jpg");
								if ($flag) resizeImage($pht_width, $pht_height, $pht_dir."/".$refund->refundNumber.".jpg", $pht_dir."/".$refund->refundNumber.".jpg");
							}
						} else $mode = "error";
					} else $mode = "over";
					break;
				case "edit":
					$photo_name = $HTTP_POST_FILES['photo']['name'];
					$photo_size = $HTTP_POST_FILES['photo']['size'];
					$photo_type = $HTTP_POST_FILES['photo']['type'];
					$photo_tmp = $HTTP_POST_FILES['photo']['tmp_name'];
					if ($photo_size <= $max_attach) {
						$apply_no = $_POST["apply_no"];
						$cf_apply_no = $_POST["cf_apply_no"];
						$kind = $_POST["kind"];
						$student = $_POST["student"];
						$vacate_flag = $_POST["vacate_flag"];
						$method_type = $_POST["method_type"];
						$dorm = $_POST["dorm"];
						$room = $_POST["room"];
						$refund_flag = $_POST["refund_flag"];
						$old_period = $_POST["old_period"];
						$new_period = $_POST["new_period"];
						$reason = htmlspecialchars(addslashes($_POST["reason"]));
						$fname = htmlspecialchars(addslashes($_POST["fname"]));
						$mname = htmlspecialchars(addslashes($_POST["mname"]));
						$lname = htmlspecialchars(addslashes($_POST["lname"]));
						$email = htmlspecialchars(addslashes($_POST["email"]));
						$method_info1 = htmlspecialchars(addslashes($_POST["method_info1"]));
						$method_info2 = htmlspecialchars(addslashes($_POST["method_info2"]));
						$method_info3 = htmlspecialchars(addslashes($_POST["method_info3"]));
						$method_info4 = htmlspecialchars(addslashes($_POST["method_info4"]));
						$method_info5 = htmlspecialchars(addslashes($_POST["method_info5"]));
						$method_info6 = htmlspecialchars(addslashes($_POST["method_info6"]));
						$addr_line2 = htmlspecialchars(addslashes($_POST["addr_line2"]));
						$addr_line3 = htmlspecialchars(addslashes($_POST["addr_line3"]));
						$addr_city = htmlspecialchars(addslashes($_POST["addr_city"]));
						$addr_state = htmlspecialchars(addslashes($_POST["addr_state"]));
						$addr_postal = htmlspecialchars(addslashes($_POST["addr_postal"]));
						$addr_country = htmlspecialchars(addslashes($_POST["addr_country"]));
						$admin = htmlspecialchars(addslashes($_POST["admin"]));
						if ($kind != "L") $kind = "U";
						if ($vacate_flag != "Y") $vacate_flag = "N";
						if ($method_type != "M" && $method_type != "O") $method_type = "W";
						if ($dorm != "ANAM2" && $dorm != "ANAMG") $dorm = "IHOUSE";
						if ($refund_flag != "Y") $refund_flag = "N";
						if ($_POST["dob_yy"] && $_POST["dob_mm"] && $_POST["dob_dd"]) $dob = $_POST["dob_yy"] . "-" . $_POST["dob_mm"] . "-" . $_POST["dob_dd"];
						else $dob = "0000-00-00";
						if ($_POST["vacate_yy"] && $_POST["vacate_mm"] && $_POST["vacate_dd"]) $vacate = $_POST["vacate_yy"] . "-" . $_POST["vacate_mm"] . "-" . $_POST["vacate_dd"];
						else $vacate = "0000-00-00";
						if ($vacate_flag == "Y") $vacate = "0000-00-00";
						if ($refund_flag == "Y") {
							$cf_apply_no = 0;
							$new_period = "";
							if ($method_type == "M") {
								$method_info1 = $method_info4;
								$method_info2 = $method_info5;
								$method_info3 = $method_info6;
								$method_info4 = "";
								$method_info5 = "";
								$method_info6 = "";
							} else if ($method_type == "O") {
								$addr_city = "";
								$addr_state = "";
								$addr_postal = "";
							} else {
								$method_info4 = "";
								$method_info5 = "";
								$method_info6 = "";
								$addr_line2 = "";
								$addr_line3 = "";
								$addr_city = "";
								$addr_state = "";
								$addr_postal = "";
								$addr_country = "";
							}
						} else {
							$reason = "";
							$method_info1 = "";
							$method_info2 = "";
							$method_info3 = "";
							$method_info4 = "";
							$method_info5 = "";
							$method_info6 = "";
							$addr_line2 = "";
							$addr_line3 = "";
							$addr_city = "";
							$addr_state = "";
							$addr_postal = "";
							$addr_country = "";
						}
						if (!is_numeric($apply_no)) $apply_no = 0;
						if (!is_numeric($cf_apply_no)) $cf_apply_no = 0;
						$flag = $refund->updateRefund($no, $apply_no, $cf_apply_no, $kind, $student, $fname, $mname, $lname, $dob, $email, $vacate, $reason, $method_type, $method_info1, $method_info2, $method_info3, $method_info4, $method_info5, $method_info6, $addr_line2, $addr_line3, $addr_city, $addr_state, $addr_postal, $addr_country, $dorm, $room, $old_period, $new_period, $admin);
						if ($flag) {
							if (is_uploaded_file($photo)) {
								$flag = move_uploaded_file($photo_tmp, $pht_dir."/".$no.".jpg");
								if ($flag) resizeImage($pht_width, $pht_height, $pht_dir."/".$no.".jpg", $pht_dir."/".$no.".jpg");
							} else if ($no && $pht_del == "Y" && file_exists($pht_dir."/".$no.".jpg")) unlink($pht_dir."/".$no.".jpg");
						} else $mode = "error";
					} else $mode = "over";
					break;
				case "del":
					$arr_no = explode(",", $no);
					for ($i = 0; $i < count($arr_no); $i++) {
						$flag = $refund->deleteRefund($arr_no[$i]);
						if ($flag) {
							if (file_exists($pht_dir."/".$arr_no[$i].".jpg")) unlink($pht_dir."/".$arr_no[$i].".jpg");
						} else {
							$mode = "error";
							break;
						} 
					}
					break;
				case "app":
					$approve = $_POST["approve"];
					$price = $_POST["price"];
					$price1 = $_POST["price1"];
					$price2 = $_POST["price2"];
					if ($_POST["app_yy"] && $_POST["app_mm"] && $_POST["app_dd"]) $app_dt = $_POST["app_yy"] . "-" . $_POST["app_mm"] . "-" . $_POST["app_dd"];
					else $app_dt = "0000-00-00";
					if (!is_numeric($price)) $price = 0;
					if (!is_numeric($price1)) $price1 = 0;
					if (!is_numeric($price2)) $price2 = 0;
					if ($approve != "Y" && $approve != "C") $approve = "N";
					if ($approve != "Y") $app_dt = "0000-00-00";
					$flag = $refund->updateApprove($no, $approve, $price, $price1, $price2, $app_dt, $ihouse_admin_info[grade]);
					if (!$flag) $mode = "error";
					break;
				case "app_list":
					if ($_POST["app_yy"] && $_POST["app_mm"] && $_POST["app_dd"]) $app_dt = $_POST["app_yy"] . "-" . $_POST["app_mm"] . "-" . $_POST["app_dd"];
					else $app_dt = "0000-00-00";
					$arr_no = explode(",", $no);
					for ($i = 0; $i < count($arr_no); $i++) {
						$refund->refundDeduction1 = 0;
						$refund->refundDeduction2 = 0;
						$refund->refundDeduction3 = 0;
						$refund->getRefundInfo($arr_no[$i]);
						$flag = $refund->updateApprove($arr_no[$i], "Y", $refund->refundDeduction1, $refund->refundDeduction2, $refund->refundDeduction3, $app_dt, $ihouse_admin_info[grade]);
						if (!$flag) {
							$mode = "error";
							break;
						} 
					}
					break;
			}
			$refund->closeDatabase();
			unset($refund);
			
			if ($mode == "error") {
				echo "<script language=\"javascript\">";
				echo "alert(\"작업수행 중 오류가 발생하였습니다.\\n\\n나중에 다시 시도해 주세요.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "over") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"사진 파일 용량은 " . round($max_attach / 1024 / 1024, 0) . "M이하여야 합니다.\\n\\n확인 후 다시 시도해 주세요.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "edit" || $mode == "app") header("Location: re_view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_app=$s_app&s_kind=$s_kind&s_new=$s_new&s_period=$s_period&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2");
			else if ($mode == "del" || $mode == "app_list") header("Location: re_list.php?page=$page&s_type=$s_type&s_text=$s_text&s_app=$s_app&s_kind=$s_kind&s_new=$s_new&s_period=$s_period&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2");
			else header("Location: re_list.php?s_app=$s_app&s_kind=$s_kind&s_new=$s_new&s_period=$s_period");
		}
	}
?>