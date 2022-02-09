<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/application_tpl.php");

	switch ($mode) {
		case "apply":
			$email = $_POST["email"];
			$email = addslashes($email);
			$email = htmlspecialchars($email);
			$period = $_POST["period"];
			$pw = $_POST["pw"];
			if ($application->hasSamePeriod($email, $period)) $mode = "period";
			else {
				$current = $_POST["current"];
				$mate_id = $_POST["mate_id"];
				$mate_yy = $_POST["mate_yy"];
				$mate_mm = $_POST["mate_mm"];
				$mate_dd = $_POST["mate_dd"];
				$match_pre1 = $_POST["match_pre1"];
				$match_pre2 = $_POST["match_pre2"];
				$match_pre3 = $_POST["match_pre3"];
				$match_pre4 = $_POST["match_pre4"];
				$match_pre5 = $_POST["match_pre5"];
				$match_pre6 = $_POST["match_pre6"];
				$dorm_waived = $_POST["dorm_waived"];
				$room_prefer = $_POST["room_prefer"];
				$room = $_POST["room"];
				$rate = $_POST["rate1"] . "," . $_POST["rate2"] . "," . $_POST["rate3"] . "," . $_POST["rate4"] . "," . $_POST["rate5"] . "," . $_POST["rate6"] . "," . $_POST["rate7"] . "," . $_POST["rate8"];
				$mate_nm = $_POST["mate_nm"];
				$mate_nm = addslashes($mate_nm);
				$mate_nm = htmlspecialchars($mate_nm);
				if ($current != "Y") $current = "N";
				if ($match_pre1 != "Y" && $match_pre1 != "N") $match_pre1 = "M";
				if ($match_pre2 != "Y" && $match_pre2 != "N") $match_pre2 = "M";
				if ($match_pre3 != "Y" && $match_pre3 != "N") $match_pre3 = "M";
				if ($match_pre4 != "Y" && $match_pre4 != "N") $match_pre4 = "M";
				if ($match_pre5 != "Y" && $match_pre5 != "N") $match_pre5 = "M";
				if ($match_pre6 != "Y" && $match_pre6 != "N") $match_pre6 = "M";
				if ($mate_yy && $mate_mm && $mate_dd) $mate_dob = $mate_yy . "-" . $mate_mm . "-" . $mate_dd;
				else $mate_dob = "0000-00-00";
				if (!$application->getApplicationNumber(date("Y").date("m"))) $app_no = date("Y"). date("m") . "0001";
				else $app_no = "";
				if ($current != "Y") $room_prefer = "";
				$flag = $application->insertApplication($app_no, $email, $dorm_waived, $room_prefer, $mate_nm, $mate_id, $mate_dob, $match_pre1, $match_pre2, $match_pre3, $match_pre4, $match_pre5, $match_pre6, $room, $period);
				$no = $application->applyNumber;
				if ($flag) {
					$flag = $application->insertPreference($rate, $no);
					if($flag) {
						//if ($current != "Y") $flag = $application->insertPayment($no, "D", date("Y-m-d"), "200000", "DB");
						//$flag = $application->insertPayment($no, "D", date("Y-m-d"), "200000", "DB");
						//if (!$flag) {
							//$flag = $application->deleteApplication($no);
							//$mode = "error";
						//}
					} else {
						$flag = $application->deleteApplication($no);
						$mode = "error";
					}
				} else $mode = "error";
			}
			break;
		case "edit":
			$email = $_POST["email"];
			$email = addslashes($email);
			$email = htmlspecialchars($email);
			$period = $_POST["period"];
			$pw = $_POST["pw"];
			if ($application->hasSamePeriod($email, $period) && $no != $application->applyNumber) $mode = "period";
			else {
				$current = $_POST["current"];
				$mate_id = $_POST["mate_id"];
				$mate_yy = $_POST["mate_yy"];
				$mate_mm = $_POST["mate_mm"];
				$mate_dd = $_POST["mate_dd"];
				$match_pre1 = $_POST["match_pre1"];
				$match_pre2 = $_POST["match_pre2"];
				$match_pre3 = $_POST["match_pre3"];
				$match_pre4 = $_POST["match_pre4"];
				$match_pre5 = $_POST["match_pre5"];
				$match_pre6 = $_POST["match_pre6"];
				$dorm_waived = $_POST["dorm_waived"];
				$room_prefer = $_POST["room_prefer"];
				$room = $_POST["room"];
				$rate = $_POST["rate1"] . "," . $_POST["rate2"] . "," . $_POST["rate3"] . "," . $_POST["rate4"] . "," . $_POST["rate5"] . "," . $_POST["rate6"] . "," . $_POST["rate7"] . "," . $_POST["rate8"];
				$mate_nm = $_POST["mate_nm"];
				$mate_nm = addslashes($mate_nm);
				$mate_nm = htmlspecialchars($mate_nm);
				if ($current != "Y") $current = "N";
				if ($match_pre1 != "Y" && $match_pre1 != "N") $match_pre1 = "M";
				if ($match_pre2 != "Y" && $match_pre2 != "N") $match_pre2 = "M";
				if ($match_pre3 != "Y" && $match_pre3 != "N") $match_pre3 = "M";
				if ($match_pre4 != "Y" && $match_pre4 != "N") $match_pre4 = "M";
				if ($match_pre5 != "Y" && $match_pre5 != "N") $match_pre5 = "M";
				if ($match_pre6 != "Y" && $match_pre6 != "N") $match_pre6 = "M";
				if ($mate_yy && $mate_mm && $mate_dd) $mate_dob = $mate_yy . "-" . $mate_mm . "-" . $mate_dd;
				else $mate_dob = "0000-00-00";
				if ($current != "Y") $room_prefer = "";
				$flag = $application->updateApplication($no, $email, $dorm_waived, $room_prefer, $mate_nm, $mate_id, $mate_dob, $match_pre1, $match_pre2, $match_pre3, $match_pre4, $match_pre5, $match_pre6, $room, $period);
				if ($flag) {
					if ($rate) {
						$flag = $application->deletePreference($no);
						if ($flag) {
							$flag = $application->insertPreference($rate, $no);
							if (!$flag) $mode = "error";
						} else $mode = "error";
					}
				} else $mode = "error";
			}
			break;
		case "refund":
		case "transfer":
			$photo_name = $HTTP_POST_FILES['photo']['name'];
			$photo_size = $HTTP_POST_FILES['photo']['size'];
			$photo_type = $HTTP_POST_FILES['photo']['type'];
			$photo_tmp = $HTTP_POST_FILES['photo']['tmp_name'];
			if ($photo_size <= $max_attach) {
				$cf_no = $_POST["cf_no"];
				$application->getApplicationInfo($no);
				if (!$application->applyNumber) $mode = "no_apply";
				else if ($application->applyState != "FD" && $application->isRefundExist($no)) $mode = "exist";
				else {
					$refund_flag = $_POST["refund_flag"];
					if ($refund_flag != "Y") $refund_flag = "N";
					$process_flag = true;
					/*
					$process_flag = false;
					if ($refund_flag == "Y") {
						$cur_date = date("Y-m-d");
						if ($application->linkPeriodCode == "2008FA" && $cur_date <= "2009-02-15") $process_flag = true;
						else if ($application->linkPeriodCode == "2008MA" && $cur_date <= "2008-10-15") $process_flag = true;
						else if ($application->linkPeriodCode == "2008MB" && $cur_date <= "2008-09-15") $process_flag = true;
						else if ($application->linkPeriodCode == "2008SA" && $cur_date <= "2008-08-16") $process_flag = true;
						else if ($application->linkPeriodCode == "2008WA" && $cur_date <= "2008-03-28") $process_flag = true;
						else if ($application->linkPeriodCode == "2008WB" && $cur_date <= "2008-04-17") $process_flag = true;
						else if ($application->linkPeriodCode == "2007FA" && $cur_date <= "2008-02-15") $process_flag = true;
						else if ($application->linkPeriodCode == "2009WA" && $cur_date <= "2009-03-28") $process_flag = true;
						else if ($application->linkPeriodCode == "2009WB" && $cur_date <= "2009-04-17") $process_flag = true;
					} else $process_flag = true;
					*/
					if (!$process_flag) $mode = "exceed";
					else {
						$kind = $application->applyKind;
						$student = $application->personStudentID;
						$dorm = $application->linkDormitory;
						$room = $application->linkRoomCode;
						$old_period = $application->linkPeriodCode;
						$new_period = $application->getApplicationPeriod($cf_no);
						$fname = $application->personFirstName;
						$mname = $application->personMiddleName;
						$lname = $application->personLastName;
						$dob = $application->personBirthDate;
						$email = $application->personEmail;
						$vacate_flag = $_POST["vacate_flag"];
						$reason = htmlspecialchars(addslashes($_POST["reason"]));
						$method_type = $_POST["method_type"];
						$method_info1 = htmlspecialchars(addslashes($_POST["method_info1"]));
						$method_info2 = htmlspecialchars(addslashes($_POST["method_info2"]));
						$method_info3 = htmlspecialchars(addslashes($_POST["method_info3"]));
						$method_info4 = htmlspecialchars(addslashes($_POST["method_info4"]));
						$method_info5 = htmlspecialchars(addslashes($_POST["method_info5"]));
						$method_info6 = htmlspecialchars(addslashes($_POST["method_info6"]));
						$addr1 = htmlspecialchars(addslashes($_POST["addr1"]));
						$addr2 = htmlspecialchars(addslashes($_POST["addr2"]));
						$city = htmlspecialchars(addslashes($_POST["city"]));
						$state = htmlspecialchars(addslashes($_POST["state"]));
						$postal = htmlspecialchars(addslashes($_POST["postal"]));
						$country = htmlspecialchars(addslashes($_POST["country"]));
						if ($vacate_flag != "Y") $vacate_flag = "N";
						if ($method_type != "M" && $method_type != "O") $method_type = "W";
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
								$city = "";
								$state = "";
								$postal = "";
							} else {
								$method_info4 = "";
								$method_info5 = "";
								$method_info6 = "";
								$addr1 = "";
								$addr2 = "";
								$city = "";
								$state = "";
								$postal = "";
								$country = "";
							}
						} else {
							$reason = "";
							$method_info1 = "";
							$method_info2 = "";
							$method_info3 = "";
							$method_info4 = "";
							$method_info5 = "";
							$method_info6 = "";
							$addr1 = "";
							$addr2 = "";
							$city = "";
							$state = "";
							$postal = "";
							$country = "";
						}
						$flag = $application->insertRefund($no, $cf_no, $kind, $student, $fname, $mname, $lname, $dob, $email, $vacate, $reason, $method_type, $method_info1, $method_info2, $method_info3, $method_info4, $method_info5, $method_info6, $addr1, $addr2, $city, $state, $postal, $country, $dorm, $room, $old_period, $new_period);
						if ($flag) {
							if (is_uploaded_file($photo)) {
								$flag = move_uploaded_file($photo_tmp, $bank_dir."/".$application->refundNumber.".jpg");
								if ($flag) resizeImage($bank_width, $bank_height, $bank_dir."/".$application->refundNumber.".jpg", $bank_dir."/".$application->refundNumber.".jpg");
							}
						} else $mode = "error";
					}
				}
			} else $mode = "over";
			break;
		case "defer":
			if ($application->isDeferExist($no)) $mode = "defer_exist";
			else {
				$exchange = $_POST["exchange"];
				if ($exchange != "KUSEP" && $exchange != "KIEP" && $exchange != "ISEP") $exchange = "";
				$flag = $application->insertDefer($no, $exchange);
				if (!$flag) $mode = "error";
			}
			break;
		case "upload":
			$fee_transfer_name = $HTTP_POST_FILES['fee_transfer']['name'];
			$fee_transfer_size = $HTTP_POST_FILES['fee_transfer']['size'];
			$fee_transfer_type = $HTTP_POST_FILES['fee_transfer']['type'];
			$fee_transfer_tmp = $HTTP_POST_FILES['fee_transfer']['tmp_name'];
			$fee_support_name = $HTTP_POST_FILES['fee_support']['name'];
			$fee_support_size = $HTTP_POST_FILES['fee_support']['size'];
			$fee_support_type = $HTTP_POST_FILES['fee_support']['type'];
			$fee_support_tmp = $HTTP_POST_FILES['fee_support']['tmp_name'];
			$tb_test_name = $HTTP_POST_FILES['tb_test']['name'];
			$tb_test_size = $HTTP_POST_FILES['tb_test']['size'];
			$tb_test_type = $HTTP_POST_FILES['tb_test']['type'];
			$tb_test_tmp = $HTTP_POST_FILES['tb_test']['tmp_name'];
			if ($fee_transfer_size <= $max_attach && $fee_support_size <= $max_attach && $tb_test_size <= $max_attach) {
				if (is_uploaded_file($fee_transfer)) {
					$flag = move_uploaded_file($fee_transfer_tmp, $fee_transfer_dir."/".$no.".jpg");
					if ($flag) resizeImage($fee_transfer_width, $fee_transfer_height, $fee_transfer_dir."/".$no.".jpg", $fee_transfer_dir."/".$no.".jpg");
				}
				if (is_uploaded_file($fee_support)) {
					$flag = move_uploaded_file($fee_support_tmp, $fee_support_dir."/".$no.".jpg");
					if ($flag) resizeImage($fee_support_width, $fee_support_height, $fee_support_dir."/".$no.".jpg", $fee_support_dir."/".$no.".jpg");
				}
				if (is_uploaded_file($tb_test)) {
					$flag = move_uploaded_file($tb_test_tmp, $tb_test_dir."/".$no.".jpg");
					if ($flag) resizeImage($tb_test_width, $tb_test_height, $tb_test_dir."/".$no.".jpg", $tb_test_dir."/".$no.".jpg");
				}
			} else $mode = "over";
			break;
	}

	$application->closeDatabase();
	unset($application);
	
	if ($mode == "error") {
		echo "<script language=\"javascript\">";
		echo "alert(\"Unexpected error is occured.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "over") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"The maximum size of image file is " . round($max_attach / 1024 / 1024, 0) . " M.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "period") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Sorry. Your online residence application is already registered.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "apply") {
		echo "<form name=\"ActionForm\" action=\"../../src/apply/view_app.php\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"no\" value=\"$no\">";
		echo "<input type=\"hidden\" name=\"email\" value=\"$email\">";
		echo "<input type=\"hidden\" name=\"pw\" value=\"$pw\">";
		echo "</form>";
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Thank you and your online residence application is successfully registered.\");";
		echo "document.ActionForm.submit();";
		echo "</script>";
	} else if ($mode == "edit") {
		echo "<form name=\"ActionForm\" action=\"../../src/apply/list_app.php\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"no\" value=\"$no\">";
		echo "<input type=\"hidden\" name=\"email\" value=\"$email\">";
		echo "<input type=\"hidden\" name=\"pw\" value=\"$pw\">";
		echo "</form>";
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Your online residence application is successfully changed.\");";
		echo "document.ActionForm.submit();";
		echo "</script>";
	} else if ($mode == "no") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Sorry. Your online application cannot be registered.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "no_apply") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"There is not correspondant application.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "exist") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"You already requested a refund.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "exceed") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Deposit refund request deadline has already been passed according to the deposit refund schedule.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "refund") {
		echo "<form name=\"ActionForm\" action=\"../../src/apply/view_app.php\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"no\" value=\"$no\">";
		echo "<input type=\"hidden\" name=\"email\" value=\"$email\">";
		echo "<input type=\"hidden\" name=\"pw\" value=\"$pw\">";
		echo "</form>";
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Thank you. Your request is successfully registered.\");";
		echo "document.ActionForm.submit();";
		echo "</script>";
	} else if ($mode == "transfer") {
		echo "<form name=\"ActionForm\" action=\"../../src/apply/payment.php\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"email\" value=\"$email\">";
		echo "<input type=\"hidden\" name=\"pw\" value=\"$pw\">";
		echo "</form>";
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Thank you. Your request is successfully registered.\");";
		echo "document.ActionForm.submit();";
		echo "</script>";
	} else if ($mode == "defer_exist") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Residence Hall Fee Payment Deferral Application/Agreement is aleady applied.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "defer") {
		echo "<form name=\"ActionForm\" action=\"../../src/apply/view_app.php\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"no\" value=\"$no\">";
		echo "<input type=\"hidden\" name=\"email\" value=\"$email\">";
		echo "<input type=\"hidden\" name=\"pw\" value=\"$pw\">";
		echo "</form>";
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Thank you. Your request is successfully registered.\");";
		echo "document.ActionForm.submit();";
		echo "</script>";
	} else if ($mode == "upload") {
		echo "<form name=\"ActionForm\" action=\"../../src/apply/view_app.php\" method=\"post\">";
		echo "<input type=\"hidden\" name=\"no\" value=\"$no\">";
		echo "<input type=\"hidden\" name=\"email\" value=\"$email\">";
		echo "<input type=\"hidden\" name=\"pw\" value=\"$pw\">";
		echo "</form>";
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Thank you. Your scan(image) files are successfully saved.\");";
		echo "document.ActionForm.submit();";
		echo "</script>";
	} else header("Location: ../../src/main/page.php?code=intro");
?>