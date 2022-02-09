<?
	include_once("../common/login_tpl.php");
	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 6 || (int)$ihouse_admin_info[grade] == 7 || (int)$ihouse_admin_info[grade] == 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/grad_refund_tpl.php");
			switch ($mode) {
				case "new":
					$photo_name = $HTTP_POST_FILES['photo']['name'];
					$photo_size = $HTTP_POST_FILES['photo']['size'];
					$photo_type = $HTTP_POST_FILES['photo']['type'];
					$photo_tmp = $HTTP_POST_FILES['photo']['tmp_name'];
					if ($photo_size <= $max_attach) {
						$apply_no = $_POST["apply_no"];
						$cf_apply_no = $_POST["cf_apply_no"];
						$student = $_POST["student"];
						$vacate_flag = $_POST["vacate_flag"];
						$method_type = $_POST["method_type"];
						$room = $_POST["room"];
						$refund_flag = $_POST["refund_flag"];
						$old_period = $_POST["old_period"];
						$new_period = $_POST["new_period"];
						$fname = $_POST["fname"];
						$fname = addslashes($fname);
						$fname = htmlspecialchars($fname);
						$mname = $_POST["mname"];
						$mname = addslashes($mname);
						$mname = htmlspecialchars($mname);
						$lname = $_POST["lname"];
						$lname = addslashes($lname);
						$lname = htmlspecialchars($lname);
						$email = $_POST["email"];
						$email = addslashes($email);
						$email = htmlspecialchars($email);
						$method_info1 = $_POST["method_info1"];
						$method_info1 = addslashes($method_info1);
						$method_info1 = htmlspecialchars($method_info1);
						$method_info2 = $_POST["method_info2"];
						$method_info2 = addslashes($method_info2);
						$method_info2 = htmlspecialchars($method_info2);
						$method_info3 = $_POST["method_info3"];
						$method_info3 = addslashes($method_info3);
						$method_info3 = htmlspecialchars($method_info3);
						$method_info4 = $_POST["method_info4"];
						$method_info4 = addslashes($method_info4);
						$method_info4 = htmlspecialchars($method_info4);
						$method_info5 = $_POST["method_info5"];
						$method_info5 = addslashes($method_info5);
						$method_info5 = htmlspecialchars($method_info5);
						$method_info6 = $_POST["method_info6"];
						$method_info6 = addslashes($method_info6);
						$method_info6 = htmlspecialchars($method_info6);
						$addr_line2 = $_POST["addr_line2"];
						$addr_line2 = addslashes($addr_line2);
						$addr_line2 = htmlspecialchars($addr_line2);
						$addr_line3 = $_POST["addr_line3"];
						$addr_line3 = addslashes($addr_line3);
						$addr_line3 = htmlspecialchars($addr_line3);
						$addr_city = $_POST["addr_city"];
						$addr_city = addslashes($addr_city);
						$addr_city = htmlspecialchars($addr_city);
						$addr_state = $_POST["addr_state"];
						$addr_state = addslashes($addr_state);
						$addr_state = htmlspecialchars($addr_state);
						$addr_postal = $_POST["addr_postal"];
						$addr_postal = addslashes($addr_postal);
						$addr_postal = htmlspecialchars($addr_postal);
						$addr_country = $_POST["addr_country"];
						$addr_country = addslashes($addr_country);
						$addr_country = htmlspecialchars($addr_country);
						$admin = $_POST["admin"];
						$admin = addslashes($admin);
						$admin = htmlspecialchars($admin);
						if ($vacate_flag != "Y") $vacate_flag = "N";
						if ($method_type != "M" && $method_type != "O") $method_type = "W";
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
						$flag = $refund->insertRefund($apply_no, $cf_apply_no, $student, $fname, $mname, $lname, $dob, $email, $vacate, $method_type, $method_info1, $method_info2, $method_info3, $method_info4, $method_info5, $method_info6, $addr_line2, $addr_line3, $addr_city, $addr_state, $addr_postal, $addr_country, $room, $old_period, $new_period, $admin);
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
						$student = $_POST["student"];
						$vacate_flag = $_POST["vacate_flag"];
						$method_type = $_POST["method_type"];
						$room = $_POST["room"];
						$refund_flag = $_POST["refund_flag"];
						$old_period = $_POST["old_period"];
						$new_period = $_POST["new_period"];
						$fname = $_POST["fname"];
						$fname = addslashes($fname);
						$fname = htmlspecialchars($fname);
						$mname = $_POST["mname"];
						$mname = addslashes($mname);
						$mname = htmlspecialchars($mname);
						$lname = $_POST["lname"];
						$lname = addslashes($lname);
						$lname = htmlspecialchars($lname);
						$email = $_POST["email"];
						$email = addslashes($email);
						$email = htmlspecialchars($email);
						$method_info1 = $_POST["method_info1"];
						$method_info1 = addslashes($method_info1);
						$method_info1 = htmlspecialchars($method_info1);
						$method_info2 = $_POST["method_info2"];
						$method_info2 = addslashes($method_info2);
						$method_info2 = htmlspecialchars($method_info2);
						$method_info3 = $_POST["method_info3"];
						$method_info3 = addslashes($method_info3);
						$method_info3 = htmlspecialchars($method_info3);
						$method_info4 = $_POST["method_info4"];
						$method_info4 = addslashes($method_info4);
						$method_info4 = htmlspecialchars($method_info4);
						$method_info5 = $_POST["method_info5"];
						$method_info5 = addslashes($method_info5);
						$method_info5 = htmlspecialchars($method_info5);
						$method_info6 = $_POST["method_info6"];
						$method_info6 = addslashes($method_info6);
						$method_info6 = htmlspecialchars($method_info6);
						$addr_line2 = $_POST["addr_line2"];
						$addr_line2 = addslashes($addr_line2);
						$addr_line2 = htmlspecialchars($addr_line2);
						$addr_line3 = $_POST["addr_line3"];
						$addr_line3 = addslashes($addr_line3);
						$addr_line3 = htmlspecialchars($addr_line3);
						$addr_city = $_POST["addr_city"];
						$addr_city = addslashes($addr_city);
						$addr_city = htmlspecialchars($addr_city);
						$addr_state = $_POST["addr_state"];
						$addr_state = addslashes($addr_state);
						$addr_state = htmlspecialchars($addr_state);
						$addr_postal = $_POST["addr_postal"];
						$addr_postal = addslashes($addr_postal);
						$addr_postal = htmlspecialchars($addr_postal);
						$addr_country = $_POST["addr_country"];
						$addr_country = addslashes($addr_country);
						$addr_country = htmlspecialchars($addr_country);
						$admin = $_POST["admin"];
						$admin = addslashes($admin);
						$admin = htmlspecialchars($admin);
						if ($vacate_flag != "Y") $vacate_flag = "N";
						if ($method_type != "M" && $method_type != "O") $method_type = "W";
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
						$flag = $refund->updateRefund($no, $apply_no, $cf_apply_no, $student, $fname, $mname, $lname, $dob, $email, $vacate, $method_type, $method_info1, $method_info2, $method_info3, $method_info4, $method_info5, $method_info6, $addr_line2, $addr_line3, $addr_city, $addr_state, $addr_postal, $addr_country, $room, $old_period, $new_period, $admin);
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