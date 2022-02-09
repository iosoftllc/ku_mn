<?
	include_once("../../lib/conf.common.php");
	include_once("../../lib/func.common.php");

	$mode = $_POST["mode"];
	if ($mode == "") $mode = $_GET["mode"];
	if ($mode == "refund" || $mode == "refund1") {
		include_once("../../lib/class.cRefund.php");
		$refund = new cRefund($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $refundTable, $periodTable, $applicantTable);
		$refund->connectDatabase();
		$refund->rateTableName = $rateTable;
		$refund->paymentTableName = $paymentTable;

		switch ($mode) {
			case "refund":
				$kind = $_POST["kind"];
				$student = $_POST["student"];
				$vacate_flag = $_POST["vacate_flag"];
				$method_type = $_POST["method_type"];
				$dorm = $_POST["dorm"];
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
				if ($kind != "L") $kind = "U";
				if ($vacate_flag != "Y") $vacate_flag = "N";
				if ($method_type != "M") $method_type = "W";
				if ($dorm != "ANAM2") $dorm = "IHOUSE";
				if ($refund_flag != "Y") $refund_flag = "N";
				if ($_POST["dob_yy"] && $_POST["dob_mm"] && $_POST["dob_dd"]) $dob = $_POST["dob_yy"] . "-" . $_POST["dob_mm"] . "-" . $_POST["dob_dd"];
				else $dob = "0000-00-00";
				if ($_POST["vacate_yy"] && $_POST["vacate_mm"] && $_POST["vacate_dd"]) $vacate = $_POST["vacate_yy"] . "-" . $_POST["vacate_mm"] . "-" . $_POST["vacate_dd"];
				else $vacate = "0000-00-00";
				if ($vacate_flag == "Y") $vacate = "0000-00-00";
				if ($refund_flag == "Y") $new_period = "";
				if ($method_type == "M") {
					$method_info1 = $method_info4;
					$method_info2 = $method_info5;
					$method_info3 = "";
				}
				$flag = $refund->insertRefund($kind, $student, $fname, $mname, $lname, $dob, $email, $vacate, $method_type, $method_info1, $method_info2, $method_info3, $dorm, $room, $old_period, $new_period);
				if (!$flag) $mode = "error";
				break;
			case "refund1":
				$no = $_POST["no"];
				$cf_no = $_POST["cf_no"];
				$refund->getApplicantInfo($no);
				if (!$refund->applyNumber) $mode = "no_apply";
				else if ($refund->applyState != "FD" && $refund->isRefundExist($no)) $mode = "exist";
				else {
					$kind = $refund->applyKind;
					$student = $refund->applyStudent;
					$dorm = $refund->applyDorm;
					$room = $refund->applyRoom;
					$old_period = $refund->applyPeriod;
					$new_period = $refund->getPeriodCode($cf_no);
					$fname = $refund->applyFName;
					$mname = $refund->applyMName;
					$lname = $refund->applyLName;
					$dob = $refund->applyDOB;
					$email = $refund->applyEmail;
					$vacate_flag = $_POST["vacate_flag"];
					$method_type = $_POST["method_type"];
					$refund_flag = $_POST["refund_flag"];
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
					if ($vacate_flag != "Y") $vacate_flag = "N";
					if ($method_type != "M") $method_type = "W";
					if ($refund_flag != "Y") $refund_flag = "N";
					if ($_POST["vacate_yy"] && $_POST["vacate_mm"] && $_POST["vacate_dd"]) $vacate = $_POST["vacate_yy"] . "-" . $_POST["vacate_mm"] . "-" . $_POST["vacate_dd"];
					else $vacate = "0000-00-00";
					if ($vacate_flag == "Y") $vacate = "0000-00-00";
					if ($refund_flag == "Y") {
						$cf_no = "";
						$new_period = "";
					}
					if ($method_type == "M") {
						$method_info1 = $method_info4;
						$method_info2 = $method_info5;
						$method_info3 = "";
					}
					$flag = $refund->insertRefund1($no, $cf_no, $kind, $student, $fname, $mname, $lname, $dob, $email, $vacate, $method_type, $method_info1, $method_info2, $method_info3, $dorm, $room, $old_period, $new_period);
					if (!$flag) $mode = "error";
				}
				break;
		}

		$refund->closeDatabase();
		unset($refund);

		if ($mode == "error") {
			echo "<script language=\"javascript\">";
			echo "alert(\"Unexpected error is occured.\\n\\nPlease try again later.\");";
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
		} else {
			echo "<script langauage=\"javascript\">";
			echo "alert(\"Thank you. Your request is successfully registered.\");";
			echo "document.location.replace(\"../../src/main/page.php?code=checkout\");";
			echo "</script>";
		}
	} else {
		include_once("../../lib/class.cApplicant.php");

		$max_attach = 1024 * 1024;
		$pht_dir = "../../upload/photo";
		$pht_width = "90";
		$pht_height = "120";

		$applicant = new cApplicant($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $applicantTable, $rateTable, $periodTable, $roomTable, $priceTable, $preferenceTable, $paymentTable);
		$applicant->connectDatabase();
		$applicant->refundTableName = $refundTable;
		switch ($mode) {
			case "apply":
				$photo_name = $HTTP_POST_FILES['photo']['name'];
				$photo_size = $HTTP_POST_FILES['photo']['size'];
				$photo_type = $HTTP_POST_FILES['photo']['type'];
				$photo_tmp = $HTTP_POST_FILES['photo']['tmp_name'];
				if ($photo_size <= $max_attach) {
					$nation = $_POST["nation"];
					//if (eregi("korea", $nation)) $mode = "no";
					//else {
						$kind = $_POST["kind"];
						$student = $_POST["student"];
						$sclass = $_POST["sclass"];
						$gender = $_POST["gender"];
						$dob_yy = $_POST["dob_yy"];
						$dob_mm = $_POST["dob_mm"];
						$dob_dd = $_POST["dob_dd"];
						$mate_yy = $_POST["mate_yy"];
						$mate_mm = $_POST["mate_mm"];
						$mate_dd = $_POST["mate_dd"];
						$match_pre1 = $_POST["match_pre1"];
						$match_pre2 = $_POST["match_pre2"];
						$match_pre3 = $_POST["match_pre3"];
						$match_pre4 = $_POST["match_pre4"];
						$match_pre5 = $_POST["match_pre5"];
						$phone = $_POST["phone"];
						$cell = $_POST["cell"];
						$room_prefer = $_POST["room_prefer"];
						$case_ph = $_POST["case_ph"];
						$current = $_POST["current"];
						$room = $_POST["room"];
						$rate = $_POST["rate1"] . "," . $_POST["rate2"] . "," . $_POST["rate3"] . "," . $_POST["rate4"] . "," . $_POST["rate5"] . "," . $_POST["rate6"] . "," . $_POST["rate7"] . "," . $_POST["rate8"];
						$period = $_POST["period"];
						$fname = $_POST["fname"];
						$fname = addslashes($fname);
						$fname = htmlspecialchars($fname);
						$mname = $_POST["mname"];
						$mname = addslashes($mname);
						$mname = htmlspecialchars($mname);
						$lname = $_POST["lname"];
						$lname = addslashes($lname);
						$lname = htmlspecialchars($lname);
						$name_kr = $_POST["name_kr"];
						$name_kr = addslashes($name_kr);
						$name_kr = htmlspecialchars($name_kr);
						$nation = addslashes($nation);
						$nation = htmlspecialchars($nation);
						$major = $_POST["major"];
						$major = addslashes($major);
						$major = htmlspecialchars($major);
						$home_uni = $_POST["home_uni"];
						$home_uni = addslashes($home_uni);
						$home_uni = htmlspecialchars($home_uni);
						$home_addr = $_POST["home_addr"];
						$home_addr = addslashes($home_addr);
						$home_addr = htmlspecialchars($home_addr);
						$email = $_POST["email"];
						$email = addslashes($email);
						$email = htmlspecialchars($email);
						$mate_nm = $_POST["mate_nm"];
						$mate_nm = addslashes($mate_nm);
						$mate_nm = htmlspecialchars($mate_nm);
						$case_nm = $_POST["case_nm"];
						$case_nm = addslashes($case_nm);
						$case_nm = htmlspecialchars($case_nm);
						$case_rel = $_POST["case_rel"];
						$case_rel = addslashes($case_rel);
						$case_rel = htmlspecialchars($case_rel);
						$case_addr = $_POST["case_addr"];
						$case_addr = addslashes($case_addr);
						$case_addr = htmlspecialchars($case_addr);
						if ($sclass != "P" && $sclass != "J" && $sclass != "S" && $sclass != "M" && $sclass != "D") $sclass = "N";
						if ($match_pre1 != "Y" && $match_pre1 != "N") $match_pre1 = "M";
						if ($match_pre2 != "Y" && $match_pre2 != "N") $match_pre2 = "M";
						if ($match_pre3 != "Y" && $match_pre3 != "N") $match_pre3 = "M";
						if ($match_pre4 != "Y" && $match_pre4 != "N") $match_pre4 = "M";
						if ($match_pre5 != "Y" && $match_pre5 != "N") $match_pre5 = "M";
						if ($kind != "L") $kind = "U";
						if ($current != "Y") $current = "N";
						if ($gender != "F") $gender = "M";
						if ($dob_yy && $dob_mm && $dob_dd) $dob = $dob_yy . "-" . $dob_mm . "-" . $dob_dd;
						else $dob = "0000-00-00";
						if ($mate_yy && $mate_mm && $mate_dd) $mate_dob = $mate_yy . "-" . $mate_mm . "-" . $mate_dd;
						else $mate_dob = "0000-00-00";
						if (!$applicant->getApplicantCount(date("Y").date("m"))) $app_no = date("Y"). date("m") . "0001";
						else $app_no = "";
						if ($current != "Y") $room_prefer = "";
						$flag = $applicant->insertApplicant($app_no, $kind, $student, $sclass, $fname, $mname, $lname, $name_kr, $gender, $dob, $nation, $major, $home_uni, $home_addr, $email, $phone, $cell, $room_prefer, $current, $mate_nm, $mate_dob, $match_pre1, $match_pre2, $match_pre3, $match_pre4, $match_pre5, $case_nm, $case_rel, $case_ph, $case_addr, $room, $period);
						$no = $applicant->applyNumber;
						if ($flag) {
							$flag = $applicant->insertPreference($rate, $no);
							if($flag) {
								//if ($current != "Y") $flag = $applicant->insertPayment($no, "D", date("Y-m-d"), "200000", "DB");
								$flag = $applicant->insertPayment($no, "D", date("Y-m-d"), "200000", "DB");
								if (!$flag) {
									$flag = $applicant->deleteApplicant($no);
									$mode = "error";
								}
							} else {
								$flag = $applicant->deleteApplicant($no);
								$mode = "error";
							}
							if ($flag) {
								/*
								$old_no = $_POST["old_no"];
								$app_no = $applicant->applyNumber;
								$applicant->getApplicantInfo($old_no);
								$kind = $applicant->applyKind;
								$student = $applicant->personStudentID;
								$dorm = $applicant->linkDormitory;
								$room = $applicant->linkRoomCode;
								$old_period = $applicant->linkPeriodCode;
								$new_period = $period;
								$fname = $applicant->personFirstName;
								$mname = $applicant->personMiddleName;
								$lname = $applicant->personLastName;
								$dob = $applicant->personBirthDate;
								$email = $applicant->personEmail;
								$vacate_flag = $_POST["vacate_flag"];
								$method_type = $_POST["method_type"];
								$refund_flag = $_POST["refund_flag"];
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
								if ($vacate_flag != "Y") $vacate_flag = "N";
								if ($method_type != "M") $method_type = "W";
								if ($refund_flag != "Y") $refund_flag = "N";
								if ($_POST["vacate_yy"] && $_POST["vacate_mm"] && $_POST["vacate_dd"]) $vacate = $_POST["vacate_yy"] . "-" . $_POST["vacate_mm"] . "-" . $_POST["vacate_dd"];
								else $vacate = "0000-00-00";
								if ($vacate_flag == "Y") $vacate = "0000-00-00";
								if ($refund_flag == "Y") {
									$app_no = "";
									$new_period = "";
								}
								if ($method_type == "M") {
									$method_info1 = $method_info4;
									$method_info2 = $method_info5;
									$method_info3 = "";
								}
								$flag = $applicant->insertRefund1($old_no, $app_no, $kind, $student, $fname, $mname, $lname, $dob, $email, $vacate, $method_type, $method_info1, $method_info2, $method_info3, $dorm, $room, $old_period, $new_period);
								if (!$flag) {
									$flag = $applicant->deleteApplicant($no);
									$mode = "error";
								}
								*/
							}
							if (is_uploaded_file($photo)) {
								$flag = move_uploaded_file($photo_tmp, $pht_dir."/".$no.".jpg");
								if ($flag) resizeImage($pht_width, $pht_height, $pht_dir."/".$no.".jpg", $pht_dir."/".$no.".jpg");
							}
						} else $mode = "error";
					//}
				} else $mode = "over";
				break;
		}
		$applicant->closeDatabase();
		unset($applicant);
		
		if ($mode == "error") {
			echo "<script language=\"javascript\">";
			echo "alert(\"Unexpected error is occured.\\n\\nPlease try again later.\");";
			echo "history.go(-1);";
			echo "</script>";
		} else if ($mode == "over") {
			echo "<script langauage=\"javascript\">";
			echo "alert(\"The maximum size of photo file is " . round($max_attach / 1024 / 1024, 0) . " M.\\n\\nPlease try again later.\");";
			echo "history.go(-1);";
			echo "</script>";
		} else if ($mode == "apply") {
			echo "<script langauage=\"javascript\">";
			echo "alert(\"Thank you. Your online application is successfully registered.\");";
			echo "document.location.replace(\"../../src/apply/view.php?view_no=$no&view_fname=$fname&view_mname=$mname&view_lname=$lname\");";
			echo "</script>";
		} else if ($mode == "no") {
			echo "<script langauage=\"javascript\">";
			echo "alert(\"Sorry. Your online application cannot be registered.\");";
			echo "history.go(-1);";
			echo "</script>";
		} else header("Location: ../../src/main/page.php?code=intro");
	}
?>