<?
	include_once("../common/login_tpl.php");
	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/apply_tpl.php");
			
			switch ($mode) {
				case "new":
					$photo_name = $HTTP_POST_FILES['photo']['name'];
					$photo_size = $HTTP_POST_FILES['photo']['size'];
					$photo_type = $HTTP_POST_FILES['photo']['type'];
					$photo_tmp = $HTTP_POST_FILES['photo']['tmp_name'];
					if ($photo_size <= $max_attach) {
						$sclass = $_POST["sclass"];
						$state = $_POST["state"];
						$student = $_POST["student"];
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
						$period = $_POST["period"];
						$rate = $_POST["rate1"] . "," . $_POST["rate2"] . "," . $_POST["rate3"] . "," . $_POST["rate4"] . "," . $_POST["rate5"] . "," . $_POST["rate6"] . "," . $_POST["rate7"] . "," . $_POST["rate8"];
						$settle1 = $_POST["settle1"];
						$settle2 = $_POST["settle2"];
						$settle3 = $_POST["settle3"];
						$settle4 = $_POST["settle4"];
						$current = $_POST["current"];
						$account = $_POST["account"];
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
						$nation = $_POST["nation"];
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
						$roommate = $_POST["roommate"];
						$roommate = addslashes($roommate);
						$roommate = htmlspecialchars($roommate);
						$admin = $_POST["admin"];
						$admin = addslashes($admin);
						$admin = htmlspecialchars($admin);
						if ($sclass != "P" && $sclass != "J" && $sclass != "S" && $sclass != "M" && $sclass != "D") $sclass = "N";
						if ($state == "") $gender = "IW";
						if ($gender != "F") $gender = "M";
						if ($settle1 != "Y") $settle1 = "N";
						if ($settle2 != "Y") $settle2 = "N";
						if ($settle3 != "Y") $settle3 = "N";
						if ($settle4 != "Y") $settle4 = "N";
						if ($current != "Y") $current = "N";
						if ($match_pre1 != "Y" && $match_pre1 != "N") $match_pre1 = "M";
						if ($match_pre2 != "Y" && $match_pre2 != "N") $match_pre2 = "M";
						if ($match_pre3 != "Y" && $match_pre3 != "N") $match_pre3 = "M";
						if ($match_pre4 != "Y" && $match_pre4 != "N") $match_pre4 = "M";
						if ($match_pre5 != "Y" && $match_pre5 != "N") $match_pre5 = "M";
						if ($dob_yy && $dob_mm && $dob_dd) $dob = $dob_yy . "-" . $dob_mm . "-" . $dob_dd;
						else $dob = "0000-00-00";
						if ($mate_yy && $mate_mm && $mate_dd) $mate_dob = $mate_yy . "-" . $mate_mm . "-" . $mate_dd;
						else $mate_dob = "0000-00-00";
						if (!$applicant->getApplicantNumber(date("Y").date("m"))) $app_no = date("Y"). date("m") . "0001";
						else $app_no = "";
						if ($current != "Y") $room_prefer = "";
						$flag = $applicant->insertApplicant($app_no, $state, $s_kind, $account, $student, $sclass, $fname, $mname, $lname, $name_kr, $gender, $dob, $nation, $major, $home_uni, $home_addr, $email, $phone, $cell, $room_prefer, $current, $mate_nm, $mate_dob, $match_pre1, $match_pre2, $match_pre3, $match_pre4, $match_pre5, $case_nm, $case_rel, $case_ph, $case_addr, $period, $settle1, $settle2, $settle3, $settle4, $roommate, $admin);
						if ($flag) {
							$flag = $applicant->insertPreference($rate, $applicant->applyNumber);
							if($flag) {
								if ($current != "Y") $flag = $applicant->insertPayment($applicant->applyNumber, "D", date("Y-m-d"), "200000", "DB");
								if (!$flag) {
									$flag = $applicant->deleteApplicant($applicant->applyNumber);
									$mode = "error";
								}
							} else {
								$flag = $applicant->deleteApplicant($applicant->applyNumber);
								$mode = "error";
							}
							if (is_uploaded_file($photo)) {
								$flag = move_uploaded_file($photo_tmp, $pht_dir."/".$applicant->applyNumber.".jpg");
								if ($flag) resizeImage($pht_width, $pht_height, $pht_dir."/".$applicant->applyNumber.".jpg", $pht_dir."/".$applicant->applyNumber.".jpg");
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
						$no = $_POST["no"];
						$sclass = $_POST["sclass"];
						$sel_rate = $_POST["sel_rate"];
						$state = $_POST["state"];
						$student = $_POST["student"];
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
						$period = $_POST["period"];
						$rate = $_POST["rate1"] . "," . $_POST["rate2"] . "," . $_POST["rate3"] . "," . $_POST["rate4"] . "," . $_POST["rate5"] . "," . $_POST["rate6"] . "," . $_POST["rate7"] . "," . $_POST["rate8"];
						$settle1 = $_POST["settle1"];
						$settle2 = $_POST["settle2"];
						$settle3 = $_POST["settle3"];
						$settle4 = $_POST["settle4"];
						$current = $_POST["current"];
						$account = $_POST["account"];
						$pht_del = $_POST["pht_del"];
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
						$nation = $_POST["nation"];
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
						$roommate = $_POST["roommate"];
						$roommate = addslashes($roommate);
						$roommate = htmlspecialchars($roommate);
						$admin = $_POST["admin"];
						$admin = addslashes($admin);
						$admin = htmlspecialchars($admin);
						$sel_rate = trim($_POST["rate".$sel_rate]);
						if ($sclass != "P" && $sclass != "J" && $sclass != "S" && $sclass != "M" && $sclass != "D") $sclass = "N";
						if ($state == "") $state = "IW";
						if ($gender != "F") $gender = "M";
						if ($settle1 != "Y") $settle1 = "N";
						if ($settle2 != "Y") $settle2 = "N";
						if ($settle3 != "Y") $settle3 = "N";
						if ($settle4 != "Y") $settle4 = "N";
						if ($current != "Y") $current = "N";
						if ($match_pre1 != "Y" && $match_pre1 != "N") $match_pre1 = "M";
						if ($match_pre2 != "Y" && $match_pre2 != "N") $match_pre2 = "M";
						if ($match_pre3 != "Y" && $match_pre3 != "N") $match_pre3 = "M";
						if ($match_pre4 != "Y" && $match_pre4 != "N") $match_pre4 = "M";
						if ($match_pre5 != "Y" && $match_pre5 != "N") $match_pre5 = "M";
						if ($dob_yy && $dob_mm && $dob_dd) $dob = $dob_yy . "-" . $dob_mm . "-" . $dob_dd;
						else $dob = "0000-00-00";
						if ($mate_yy && $mate_mm && $mate_dd) $mate_dob = $mate_yy . "-" . $mate_mm . "-" . $mate_dd;
						else $mate_dob = "0000-00-00";
						if ($current != "Y") $room_prefer = "";
						$flag = $applicant->updateApplicant($no, $sel_rate, $state, $account, $student, $sclass, $fname, $mname, $lname, $name_kr, $gender, $dob, $nation, $major, $home_uni, $home_addr, $email, $phone, $cell, $room_prefer, $current, $mate_nm, $mate_dob, $match_pre1, $match_pre2, $match_pre3, $match_pre4, $match_pre5, $case_nm, $case_rel, $case_ph, $case_addr, $period, $settle1, $settle2, $settle3, $settle4, $roommate, $admin);
						if ($flag) {
							if ($rate) {
								$flag = $applicant->deletePreference($no);
								if ($flag) {
									$flag = $applicant->insertPreference($rate, $no);
									if ($flag) {
										if ($sel_rate && $period) $flag = $applicant->updateResidenceFee($no, $sel_rate, $period);
									} else $mode = "error";
								} else $mode = "error";
							}
							if (is_uploaded_file($photo)) {
								$flag = move_uploaded_file($photo_tmp, $pht_dir."/".$no.".jpg");
								if ($flag) resizeImage($pht_width, $pht_height, $pht_dir."/".$no.".jpg", $pht_dir."/".$no.".jpg");
							} else if ($no && $pht_del == "Y" && file_exists($pht_dir."/".$no.".jpg")) unlink($pht_dir."/".$no.".jpg");
						} else $mode = "error";
					} else $mode = "over";
					break;
				case "del":
					$no = $_POST["no"];
					$arr_no = explode(",", $no);
					for ($i = 0; $i < count($arr_no); $i++) {
						$flag = $applicant->deleteApplicant($arr_no[$i]);
						if ($flag) {
							if (file_exists($pht_dir."/".$arr_no[$i].".jpg")) unlink($pht_dir."/".$arr_no[$i].".jpg");
						} else {
							$mode = "error";
							break;
						} 
					}
					break;
				case "add":
					$no = $_POST["no"];
					$period = $_POST["period"];
					$flag = $applicant->copyApplicant($no, $period);
					if (!$flag) $mode = "error";
					break;
				case "assign":
					$no = $_POST["no"];
					$room = $_POST["room"];
					$flag = $applicant->assignRoom($no, $room);
					if (!$flag) $mode = "error";
					break;
				case "pay_new":
					$no = $_POST["no"];
					$price = $_POST["price"];
					$pay_type = $_POST["pay_type"];
					$pay_yy = $_POST["pay_yy"];
					$pay_mm = $_POST["pay_mm"];
					$pay_dd = $_POST["pay_dd"];
					$detail = $_POST["detail"];
					if (!$detail) $detail = "ET";
					if ($pay_type != "+") $pay_type = "-";
					if ($detail == "DB" || $detail == "DD" || $detail == "LF" || $detail == "CC") $pay_type = "+";
					else if ($detail != "ET") $pay_type = "-";
					if (!is_numeric($price)) $price = 0;
					if ($pay_type == "-") $price = "-" . $price;
					if ($pay_yy && $pay_mm && $pay_dd) {
						$pay_dt = $pay_yy . "-" . $pay_mm . "-" . $pay_dd;
						if ($price < 0) $pay_dt .= " 23:59:59";
					} else $pay_dt = "0000-00-00 00:00:00";
					$flag = $applicant->insertPayment($no, "E", $pay_dt, $price, $detail);
					if ($flag) {
						if ($detail == "DP") $state = "DP";
						else if ($detail == "DF") $state = "DD";
						else if ($detail == "RP") $state = "FP";
						else if ($detail == "RF") $state = "FD";
						else if ($detail == "RS") $state = "FS";
						$flag = $applicant->updateApplicantState($no, $state);
					} else $mode = "error";
					break;
				case "pay_edit":
					$no = $_POST["no"];
					$pay_no = $_POST["pay_no"];
					$price = $_POST["price"];
					$pay_type = $_POST["pay_type"];
					$pay_yy = $_POST["pay_yy"];
					$pay_mm = $_POST["pay_mm"];
					$pay_dd = $_POST["pay_dd"];
					$detail = $_POST["detail"];
					if (!$detail) $detail = "ET";
					if ($pay_type != "+") $pay_type = "-";
					if ($detail == "DB" || $detail == "DD" || $detail == "LF" || $detail == "CC") $pay_type = "+";
					else if ($detail != "ET") $pay_type = "-";
					if (!is_numeric($price)) $price = 0;
					if ($pay_type == "-") $price = "-" . $price;
					if ($pay_yy && $pay_mm && $pay_dd) {
						$pay_dt = $pay_yy . "-" . $pay_mm . "-" . $pay_dd;
						if ($price < 0) $pay_dt .= " 23:59:59";
					} else $pay_dt = "0000-00-00";
					$flag = $applicant->updatePayment($pay_no, $pay_dt, $price, $detail);
					if ($flag) {
						if ($detail == "DP") $state = "DP";
						else if ($detail == "DF") $state = "DD";
						else if ($detail == "RP") $state = "FP";
						else if ($detail == "RF") $state = "FD";
						else if ($detail == "RS") $state = "FS";
						$flag = $applicant->updateApplicantState($no, $state);
					} else $mode = "error";
					break;
				case "pay_del":
					$no = $_POST["no"];
					$pay_no = $_POST["pay_no"];
					$arr_no = explode(",", $pay_no);
					for ($i = 0; $i < count($arr_no); $i++) {
						$flag = $applicant->deletePayment($arr_no[$i]);
						if (!$flag) {
							$mode = "error";
							break;
						}
					}
					break;
				case "room";
					include_once("../../lib/class.rFastTemplate.php");
					$no = $_POST["no"];
					$applicant->getApplicantInfo($no);
					$name = $applicant->personLastName . ", " . $applicant->personFirstName . " " . $applicant->personMiddleName;
					$price = $applicant->getApplicantPrice($applicant->linkRateCode, $applicant->linkPeriodCode);
					$period = $applicant->linkPeriodName . " (" . getEnglishDate($applicant->linkPeriodSDate) . " - " . getEnglishDate($applicant->linkPeriodEDate) . ")";
					$from = "$cf_email_under";
					$to = $applicant->personEmail;
					//$to = "ksh@intia.co.kr";
					//$to = "heeryun@korea.ac.kr";
					$subject = "[KU Residence Life] Room Assignment & Payment Information";
					$msg = "Thank you for your on-line residence hall application. Please refer to the following room assignment and payment Information<br><br>\n";
					$msg .= "Application number: " . $applicant->applyNumber . "<br>\n";
					$msg .= "Name: " . $name . "<br>\n";
					$msg .= "Your room number: " . $applicant->linkRoomCode . "<br>\n";
					$msg .= "Session Applied: " . $period . "<br><br>\n";
					$pay_total = 0;
					$applicant->getPaymentList($applicant->applyNumber);
					if (count($applicant->payListNumber)) {
						$msg .= "::: Payment History :::<br>\n";
						$msg .= "<table width='100%' border='0' cellpadding='3' cellspacing='1' bgcolor='#4B4D4C'>\n";
						$msg .= "<tr bgcolor='#FFFFFF'><td align='center'>Date</td><td align='center'>Description</td><td align='center'>Amount</td></tr>\n";
					}
					for ($j = 0; $j < count($applicant->payListNumber); $j++) {
						$pay_total += (int)$applicant->payListPrice[$j];
						$msg .= "<tr bgcolor='#FFFFFF'>\n";
						$msg .= "<td align='center'>" . getEnglishDate(substr($applicant->payListDate[$j], 0, 10)) . "</td>\n";
						$msg .= "<td align='center'>" . $applicant->getDetailValue($applicant->payListDetail[$j]) . "</td>\n";
						$msg .= "<td align='right'>" . number_format($applicant->payListPrice[$j]) . " KRW</td>\n";
						$msg .= "</tr>\n";
					}
					if (count($applicant->payListNumber)) {
						$msg .= "<tr bgcolor='#FFFFFF'><td colspan='2' align='center'><b>Total Amount Due / (Overpaid, if negative)</b></td><td align='right'><b>" . number_format($pay_total) . " KRW</b></td></tr>\n";
						$msg .= "</table>\n<br>";
					}
					$msg .= "NOTE: Total due may change to reflect damage deductions, if any, for current residents.<br><br>\n";
					$msg .= "1. Your billing statement is available online. Go to \"Check My Housing Account\" page and print your billing statement. You are required to input your application number and name to view your application status.<br><br>\n";
					$msg .= "2. Payment methods<br><br>\n";
					$msg .= "<b>In Person</b><br>\n";
					$msg .= "Find a Hana Bank branch that is closest to your work or home. Bring your billing statement to your branch of choice and pay by cash during the period from <font style='text-decoration:underline;'>December 5 to December 7, 2006</font>. Note: In person payment is available between 9:30 am and 4:30 pm on weekdays, except holidays.<br><br>\n";
					$msg .= "<b>Online</b><br>\n";
					$msg .= "Pay by Internet Banking - Electronic Funds Transfer only from a Korean bank account, during the period from <font style='text-decoration:underline;'>December 5 to December 7, 2006</font>. Note: Online payment is available between 9:30 am and 4:30 pm on weekdays, except holidays.<br><br>\n";
					$msg .= "Late fee will apply after the due date. Failure to make the payment by due date may result in forfeiture of your deposit and immediate termination of your residence hall contract.<br><br>\n";
					$msg .= "If you decide to cancel during any stage of this process, you must notify the Office of Residence Life as soon as possible to reduce the risk of penalty. Please see the contract for more information.<br><br>\n";
					$msg .= "Please print this page for your record.<br>\n";
					$msg .= "Your Application Number is <font style='text-decoration:underline;'>" . $applicant->applyNumber . "</font>.<br>\n";
					$msg .= "If you have any further questions, please contact Residence Life at <a href=\"mailto:$cf_email_under\">$cf_email_under</a>.<br><br>\n";
					$msg .= "Korea University<br>\n";
					$msg .= "Anam Residence Life<br>\n";
					$msg .= "International Residence<br>\n";
					$msg .= "Fax: 82-2-926-3464<br>\n";
					$msg .= "email: <a href=\"mailto:$cf_email_under\">$cf_email_under</a><br>\n";
					$msg .= "<a href=\"http://reslife.korea.ac.kr\">http://reslife.korea.ac.kr</a>\n";
					$flag = sendEmail($to, $from, $subject, $msg);
					if (!$flag) $mode = "error";
					break;
				case "upload";
					$attach_name = $HTTP_POST_FILES['attach']['name'];
					$attach_type = $HTTP_POST_FILES['attach']['type'];
					$attach_size = $HTTP_POST_FILES['attach']['size'];
					$attach_tmp = $HTTP_POST_FILES['attach']['tmp_name'];
					if (is_uploaded_file($attach)) {
						$row = 0;
						$success = 0;
						$fp = fopen ("$attach_tmp", "r");
						while ($data = fgetcsv($fp, 1000, ",")) {
							if (!$row) {
								$row++;
								continue;
							}
							$row++;
							$app_no = $data[0]; // 지원번호
							$state = $data[1]; // 지원상태 (IW:입사신청, DP:보증금부분납부, DD:보증금납부, RA:호실배정, PR:납부기간연장신청, FP:기숙사비부분납부, FD:기숙사비, FS:기숙사비장학금, RR:보증금반환신청, RD:보증금반환)
							$s_kind = $data[2]; // 학생종류 (U:대학부, L:어학부)
							$current = $data[3]; // 현 I House 학생 여부
							$student = $data[4]; // 학생아이디번호
							$lname = $data[5]; // 지원자영문이름
							$fname = $data[6]; // 지원자영문이름
							$gender = $data[7]; // 회원성별 (M:남자, F:여자)
							$dob = $data[8]; // 생년월일
							$email = $data[9]; // 이메일
							$phone = $data[10]; // 전화번호
							$home_addr = $data[11]; // 본국주소
							$nation = $data[12]; // 국적
							$home_uni = $data[13]; // 모교
							$major = $data[14]; // 학과
							$period = $data[15]; // 체류기간코드
							$rate = $data[16]; // 룸타입코드
							$room = $data[17]; // 룸코드
							$mname = "";
							$account = "";
							$sclass = "N";
							$name_kr = "";
							$cell = "";
							$room_prefer = "";
							$mate_nm = "";
							$mate_dob = "0000-00-00";
							$match_pre1 = "M";
							$match_pre2 = "M";
							$match_pre3 = "M";
							$match_pre4 = "M";
							$match_pre5 = "M";
							$case_nm = "";
							$case_rel = "";
							$case_ph = "";
							$case_addr = "";
							$settle1 = "N";
							$settle2 = "N";
							$settle3 = "N";
							$settle4 = "N";
							$roommate = "";
							$admin = "";
							$flag = $applicant->insertApplicant($app_no, $state, $s_kind, $account, $student, $sclass, $fname, $mname, $lname, $name_kr, $gender, $dob, $nation, $major, $home_uni, $home_addr, $email, $phone, $cell, $room_prefer, $current, $mate_nm, $mate_dob, $match_pre1, $match_pre2, $match_pre3, $match_pre4, $match_pre5, $case_nm, $case_rel, $case_ph, $case_addr, $room, $period, $settle1, $settle2, $settle3, $settle4, $roommate, $admin);
							$flag = $applicant->insertPreference($rate, $app_no);
							if ($flag) $success++;
						}
						fclose ($fp);
					} else $mode = "no_attach";
					break;
			}
			$applicant->closeDatabase();
			unset($applicant);
			
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
			} else if ($mode == "room") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"룸배정 완료메일을 성공적으로 보냈습니다.\");";
				echo "document.location.replace(\"view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_kind=$s_kind&s_state=$s_state&s_current=$s_current&s_period=$s_period&sort1=$sort1&sort2=$sort2\");";
				echo "</script>";
			} else if ($mode == "upload") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"총 " . ($row - 1) . "개 중 " . $success . "의 지원정보를 성공적으로 업로드 추가했습니다.\");";
				echo "document.location.replace('list.php');";
				echo "</script>";
			} else if ($mode == "edit" || $mode == "assign" || $mode == "pay_new" || $mode == "pay_edit" || $mode == "pay_del") header("Location: view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_kind=$s_kind&s_state=$s_state&s_current=$s_current&s_period=$s_period&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2");
			else if ($mode == "add" || $mode == "del") header("Location: list.php?page=$page&s_type=$s_type&s_text=$s_text&s_kind=$s_kind&s_state=$s_state&s_current=$s_current&s_period=$s_period&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2");
			else header("Location: list.php?s_kind=$s_kind");
		}
	}
?>