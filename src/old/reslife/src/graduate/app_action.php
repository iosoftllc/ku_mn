<?
	include_once("../common/login_tpl.php");
	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 6 || (int)$ihouse_admin_info[grade] == 7 || (int)$ihouse_admin_info[grade] == 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/grad_application_tpl.php");

			switch ($mode) {
				case "new":
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
						$current = $_POST["current"];
						$state = $_POST["state"];
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
						$room_prefer = $_POST["room_prefer"];
						$checkin = $_POST["checkin"];
						$checkout = $_POST["checkout"];
						$period = $_POST["period"];
						$rate = $_POST["rate1_code"] . "," . $_POST["rate2_code"] . "," . $_POST["rate3_code"] . "," . $_POST["rate4_code"] . "," . $_POST["rate5_code"] . "," . $_POST["rate6_code"] . "," . $_POST["rate7_code"] . "," . $_POST["rate8_code"];
						$settle1 = $_POST["settle1"];
						$settle2 = $_POST["settle2"];
						$settle3 = $_POST["settle3"];
						$settle4 = $_POST["settle4"];
						$account = $_POST["account"];
						$email = $_POST["email"];
						$email = addslashes($email);
						$email = htmlspecialchars($email);
						$mate_nm = $_POST["mate_nm"];
						$mate_nm = addslashes($mate_nm);
						$mate_nm = htmlspecialchars($mate_nm);
						$roommate = $_POST["roommate"];
						$roommate = addslashes($roommate);
						$roommate = htmlspecialchars($roommate);
						$admin = $_POST["admin"];
						$admin = addslashes($admin);
						$admin = htmlspecialchars($admin);
						if ($current != "Y") $current = "N";
						if ($state == "") $state = "IW";
						if ($settle1 != "Y") $settle1 = "N";
						if ($settle2 != "Y") $settle2 = "N";
						if ($settle3 != "Y") $settle3 = "N";
						if ($settle4 != "Y") $settle4 = "N";
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
						$flag = $application->insertApplication($app_no, $email, $state, $account, $room_prefer, $mate_nm, $mate_id, $mate_dob, $match_pre1, $match_pre2, $match_pre3, $match_pre4, $match_pre5, $match_pre6, $checkin, $checkout, $period, $settle1, $settle2, $settle3, $settle4, $roommate, $admin);
						if ($flag) {
							$flag = $application->insertPreference($rate, $application->applyNumber);
							if($flag) {
								$application->approveApplication($application->applyNumber, $ihouse_admin_info[grade], "Y");
							} else {
								$application->deleteApplication($application->applyNumber);
								$mode = "error";
							}
							if($mode != "error") {
								if (is_uploaded_file($fee_transfer)) {
									$flag = move_uploaded_file($fee_transfer_tmp, $fee_transfer_dir."/".$application->applyNumber.".jpg");
									if ($flag) resizeImage($fee_transfer_width, $fee_transfer_height, $fee_transfer_dir."/".$application->applyNumber.".jpg", $fee_transfer_dir."/".$application->applyNumber.".jpg");
								}
								if (is_uploaded_file($fee_support)) {
									$flag = move_uploaded_file($fee_support_tmp, $fee_support_dir."/".$application->applyNumber.".jpg");
									if ($flag) resizeImage($fee_support_width, $fee_support_height, $fee_support_dir."/".$application->applyNumber.".jpg", $fee_support_dir."/".$application->applyNumber.".jpg");
								}
								if (is_uploaded_file($tb_test)) {
									$flag = move_uploaded_file($tb_test_tmp, $tb_test_dir."/".$application->applyNumber.".jpg");
									if ($flag) resizeImage($tb_test_width, $tb_test_height, $tb_test_dir."/".$application->applyNumber.".jpg", $tb_test_dir."/".$application->applyNumber.".jpg");
								}
							}
						} else $mode = "error";
					} else $mode = "over";
					break;
				case "edit":
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
						$current = $_POST["current"];
						$sel_rate = $_POST["sel_rate"];
						$state = $_POST["state"];
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
						$room_prefer = $_POST["room_prefer"];
						$checkin = $_POST["checkin"];
						$checkout = $_POST["checkout"];
						$period = $_POST["period"];
						$rate = $_POST["rate1_code"] . "," . $_POST["rate2_code"] . "," . $_POST["rate3_code"] . "," . $_POST["rate4_code"] . "," . $_POST["rate5_code"] . "," . $_POST["rate6_code"] . "," . $_POST["rate7_code"] . "," . $_POST["rate8_code"];
						$settle1 = $_POST["settle1"];
						$settle2 = $_POST["settle2"];
						$settle3 = $_POST["settle3"];
						$settle4 = $_POST["settle4"];
						$account = $_POST["account"];
						$email = $_POST["email"];
						$email = addslashes($email);
						$email = htmlspecialchars($email);
						$mate_nm = $_POST["mate_nm"];
						$mate_nm = addslashes($mate_nm);
						$mate_nm = htmlspecialchars($mate_nm);
						$roommate = $_POST["roommate"];
						$roommate = addslashes($roommate);
						$roommate = htmlspecialchars($roommate);
						$admin = $_POST["admin"];
						$admin = addslashes($admin);
						$admin = htmlspecialchars($admin);
						$sel_rate = trim($_POST["rate".$sel_rate."_code"]);
						if ($current != "Y") $current = "N";
						if ($state == "") $state = "IW";
						if ($settle1 != "Y") $settle1 = "N";
						if ($settle2 != "Y") $settle2 = "N";
						if ($settle3 != "Y") $settle3 = "N";
						if ($settle4 != "Y") $settle4 = "N";
						if ($match_pre1 != "Y" && $match_pre1 != "N") $match_pre1 = "M";
						if ($match_pre2 != "Y" && $match_pre2 != "N") $match_pre2 = "M";
						if ($match_pre3 != "Y" && $match_pre3 != "N") $match_pre3 = "M";
						if ($match_pre4 != "Y" && $match_pre4 != "N") $match_pre4 = "M";
						if ($match_pre5 != "Y" && $match_pre5 != "N") $match_pre5 = "M";
						if ($match_pre6 != "Y" && $match_pre6 != "N") $match_pre6 = "M";
						if ($mate_yy && $mate_mm && $mate_dd) $mate_dob = $mate_yy . "-" . $mate_mm . "-" . $mate_dd;
						else $mate_dob = "0000-00-00";
						if ($current != "Y") $room_prefer = "";
						$flag = $application->updateApplication($no, $email, $sel_rate, $state, $account, $room_prefer, $mate_nm, $mate_id, $mate_dob, $match_pre1, $match_pre2, $match_pre3, $match_pre4, $match_pre5, $match_pre6, $checkin, $checkout, $period, $settle1, $settle2, $settle3, $settle4, $roommate, $admin);
						if ($flag) {
							if ($rate) {
								$flag = $application->deletePreference($no);
								if ($flag) {
									$flag = $application->insertPreference($rate, $no);
									if ($flag) {
										if ($sel_rate && $period) $flag = $application->updateResidenceFee($no, $sel_rate, $period);
									} else $mode = "error";
								} else $mode = "error";
							}
							$flag = $application->approveApplication($no, $ihouse_admin_info[grade], "Y");
							if($mode != "error") {
								if (is_uploaded_file($fee_transfer)) {
									$fee_transfer_del = $_POST["fee_transfer_del"];
									$flag = move_uploaded_file($fee_transfer_tmp, $fee_transfer_dir."/".$no.".jpg");
									if ($flag) resizeImage($fee_transfer_width, $fee_transfer_height, $fee_transfer_dir."/".$no.".jpg", $fee_transfer_dir."/".$no.".jpg");
								} else if ($no && $fee_transfer_del == "Y" && file_exists($fee_transfer_dir."/".$no.".jpg")) unlink($fee_transfer_dir."/".$no.".jpg");
								if (is_uploaded_file($fee_support)) {
									$fee_support_del = $_POST["fee_support_del"];
									$flag = move_uploaded_file($fee_support_tmp, $fee_support_dir."/".$no.".jpg");
									if ($flag) resizeImage($fee_support_width, $fee_support_height, $fee_support_dir."/".$no.".jpg", $fee_support_dir."/".$no.".jpg");
								} else if ($no && $fee_support_del == "Y" && file_exists($fee_support_dir."/".$no.".jpg")) unlink($fee_support_dir."/".$no.".jpg");
								if (is_uploaded_file($tb_test)) {
									$tb_test_del = $_POST["tb_test_del"];
									$flag = move_uploaded_file($tb_test_tmp, $tb_test_dir."/".$no.".jpg");
									if ($flag) resizeImage($tb_test_width, $tb_test_height, $tb_test_dir."/".$no.".jpg", $tb_test_dir."/".$no.".jpg");
								} else if ($no && $tb_test_del == "Y" && file_exists($tb_test_dir."/".$no.".jpg")) unlink($tb_test_dir."/".$no.".jpg");
							}
						} else $mode = "error";
					} else $mode = "over";
					break;
				case "del":
					$arr_no = explode(",", $no);
					for ($i = 0; $i < count($arr_no); $i++) {
						$flag = $application->deleteApplication($arr_no[$i]);
						if ($flag) {
							if (file_exists($fee_transfer_dir."/".$arr_no[$i].".jpg")) unlink($fee_transfer_dir."/".$arr_no[$i].".jpg");
							if (file_exists($fee_support_dir."/".$arr_no[$i].".jpg")) unlink($fee_support_dir."/".$arr_no[$i].".jpg");
							if (file_exists($tb_test_dir."/".$arr_no[$i].".jpg")) unlink($tb_test_dir."/".$arr_no[$i].".jpg");
						} else {
							$mode = "error";
							break;
						} 
					}
					break;
				case "add":
					$checkin = $_POST["checkin"];
					$checkout = $_POST["checkout"];
					$period = $_POST["period"];
					$flag = $application->copyApplication($no, $checkin, $checkout, $period);
					if (!$flag) $mode = "error";
					break;
				case "assign":
					$room = $_POST["room"];
					if ($application->isRoomExist($no, $room)) $mode = "exist";
					else if (!$application->isRoomAvailable($no, $room)) $mode = "book";
					else {
						$flag = $application->assignRoom($no, $room);
						if ($flag) {
							$flag = $application->updateResidenceFee1($no, $application->linkRateCode);
							$flag = $application->approveApplication($no, $ihouse_admin_info[grade], "Y");
						} else $mode = "error";
					}
					break;
				case "cancel":
					$flag = $application->cancelRoom($no);
					if ($flag) $flag = $application->approveApplication($no, $ihouse_admin_info[grade], "Y");
					else $mode = "error";
					break;
				case "pay_new":
					$price = $_POST["price"];
					$pay_type = $_POST["pay_type"];
					$pay_yy = $_POST["pay_yy"];
					$pay_mm = $_POST["pay_mm"];
					$pay_dd = $_POST["pay_dd"];
					$detail = $_POST["detail"];
					if (!$detail) $detail = "ET";
					if ($pay_type != "+") $pay_type = "-";
					if ($detail == "DB" || $detail == "DD" || $detail == "DR" || $detail == "RB" || $detail == "LF" || $detail == "OR" || $detail == "OC" || $detail == "DC" || $detail == "CF" || $detail == "TR" || $detail == "TF" || $detail == "BB") $pay_type = "+";
					else if ($detail == "DI" || $detail == "DP" || $detail == "DF" || $detail == "DW" || $detail == "RP" || $detail == "RF" || $detail == "RW" || $detail == "RS" || $detail == "OP" || $detail == "DO" || $detail == "RR" || $detail == "CR" || $detail == "TQ" || $detail == "BP") $pay_type = "-";
					if (!is_numeric($price)) $price = 0;
					if ($pay_type == "-") $price = "-" . $price;
					if ($pay_yy && $pay_mm && $pay_dd) {
						$pay_dt = $pay_yy . "-" . $pay_mm . "-" . $pay_dd;
						if ($price < 0) $pay_dt .= " 23:59:59";
					} else $pay_dt = "0000-00-00 00:00:00";
					$flag = $application->insertPayment($no, "E", $pay_dt, $price, $detail);
					if ($flag) {
						if ($detail == "DP") $state = "DP";
						else if ($detail == "DF") $state = "DD";
						else if ($detail == "RP") $state = "FP";
						else if ($detail == "RF") $state = "FD";
						else if ($detail == "RS") $state = "FS";
						$flag = $application->updateApplicationState($no, $state);
						$flag = $application->approveApplication($no, $ihouse_admin_info[grade], "Y");
					} else $mode = "error";
					break;
				case "pay_edit":
					$pay_no = $_POST["pay_no"];
					$price = $_POST["price"];
					$pay_type = $_POST["pay_type"];
					$pay_yy = $_POST["pay_yy"];
					$pay_mm = $_POST["pay_mm"];
					$pay_dd = $_POST["pay_dd"];
					$detail = $_POST["detail"];
					if (!$detail) $detail = "ET";
					if ($pay_type != "+") $pay_type = "-";
					if ($detail == "DB" || $detail == "DD" || $detail == "DR" || $detail == "RB" || $detail == "LF" || $detail == "OR" || $detail == "OC" || $detail == "DC" || $detail == "CF" || $detail == "TR" || $detail == "TF" || $detail == "BB") $pay_type = "+";
					else if ($detail == "DI" || $detail == "DP" || $detail == "DF" || $detail == "DW" || $detail == "RP" || $detail == "RF" || $detail == "RW" || $detail == "RS" || $detail == "OP" || $detail == "DO" || $detail == "RR" || $detail == "CR" || $detail == "TQ" || $detail == "BP") $pay_type = "-";
					if (!is_numeric($price)) $price = 0;
					if ($pay_type == "-") $price = "-" . $price;
					if ($pay_yy && $pay_mm && $pay_dd) {
						$pay_dt = $pay_yy . "-" . $pay_mm . "-" . $pay_dd;
						if ($price < 0) $pay_dt .= " 23:59:59";
					} else $pay_dt = "0000-00-00";
					$flag = $application->updatePayment($pay_no, $pay_dt, $price, $detail);
					if ($flag) {
						if ($detail == "DP") $state = "DP";
						else if ($detail == "DF") $state = "DD";
						else if ($detail == "RP") $state = "FP";
						else if ($detail == "RF") $state = "FD";
						else if ($detail == "RS") $state = "FS";
						$flag = $application->updateApplicationState($no, $state);
						$flag = $application->approveApplication($no, $ihouse_admin_info[grade], "Y");
					} else $mode = "error";
					break;
				case "pay_del":
					$pay_no = $_POST["pay_no"];
					$arr_no = explode(",", $pay_no);
					for ($i = 0; $i < count($arr_no); $i++) {
						$flag = $application->deletePayment($arr_no[$i]);
						if (!$flag) {
							$mode = "error";
							break;
						}
					}
					if ($flag) $flag = $application->approveApplication($no, $ihouse_admin_info[grade], "Y");
					break;
				case "room";
					include_once("../../lib/class.rFastTemplate.php");
					$application->getApplicationInfo($no);
					$name = $application->personLastName . ", " . $application->personFirstName . " " . $application->personMiddleName;
					$price = $application->getApplicationPrice($application->linkRateCode, $application->linkPeriodCode);
					$period = $application->linkPeriodName . " (" . getEnglishDate($application->linkPeriodSDate) . " - " . getEnglishDate($application->linkPeriodEDate) . ")";
					$from = $cf_email_graduate;
					$to = $application->personEmail;
					//$to = "gaultier74@naver.com";
					$subject = "[Anam Global House] Room Assignment & Payment Information";
					$msg = "Thank you for your on-line Anam Global House application. Please refer to the following room assignment and payment Information<br><br>\n";
					$msg .= "Application number: " . $application->applyNumber . "<br>\n";
					$msg .= "Name: " . $name . "<br>\n";
					$msg .= "Your room number: " . $application->linkRoomCode . "<br>\n";
					$msg .= "Session Applied: " . $period . "<br><br>\n";
					$pay_total = 0;
					$application->getPaymentList($application->applyNumber);
					if (count($application->payListNumber)) {
						$msg .= "::: Payment History :::<br>\n";
						$msg .= "<table width='100%' border='0' cellpadding='3' cellspacing='1' bgcolor='#4B4D4C'>\n";
						$msg .= "<tr bgcolor='#FFFFFF'><td align='center'>Date</td><td align='center'>Description</td><td align='center'>Amount</td></tr>\n";
					}
					for ($j = 0; $j < count($application->payListNumber); $j++) {
						$pay_total += (int)$application->payListPrice[$j];
						$msg .= "<tr bgcolor='#FFFFFF'>\n";
						$msg .= "<td align='center'>" . getEnglishDate(substr($application->payListDate[$j], 0, 10)) . "</td>\n";
						$msg .= "<td align='center'>" . $application->getDetailValue($application->payListDetail[$j]) . "</td>\n";
						$msg .= "<td align='right'>" . number_format($application->payListPrice[$j]) . " KRW</td>\n";
						$msg .= "</tr>\n";
					}
					if (count($application->payListNumber)) {
						$msg .= "<tr bgcolor='#FFFFFF'><td colspan='2' align='center'><b>Total Amount Due / (Overpaid, if negative)</b></td><td align='right'><b>" . number_format($pay_total) . " KRW</b></td></tr>\n";
						$msg .= "</table>\n<br>";
					}
					$msg .= "NOTE: Total due may change to reflect damage deductions, if any, for current residents.<br><br>\n";
					$msg .= "1. Your billing statement is available online. Go to \"Check My Housing Account\" page and print your billing statement. You are required to input your application number and name to view your application status.<br><br>\n";
					$msg .= "2. Payment methods<br><br>\n";
					$msg .= "<b>In Person</b><br>\n";
					$msg .= "Find a Hana Bank branch that is closest to your work or home. Bring your billing statement to your branch of choice and pay by cash during the period from <font style='text-decoration:underline;'>August 6, 2021 to August 13, 2021</font>. Note: In person payment is available between 9:30 am and 4:30 pm on weekdays, except holidays.<br><br>\n";
					$msg .= "<b>Online</b><br>\n";
					$msg .= "Pay by Internet Banking - Electronic Funds Transfer only from a Korean bank account, during the period from <font style='text-decoration:underline;'>August 6, 2021 to August 13, 2021</font>. Note: Online payment is available between 9:30 am and 4:30 pm on weekdays, except holidays.<br><br>\n";
					$msg .= "Late fee will apply after the due date. Failure to make the payment by due date may result in forfeiture of your deposit and immediate termination of your Anam Global House contract.<br><br>\n";
					$msg .= "If you decide to cancel during any stage of this process, you must notify the Office of Anam Global House as soon as possible to reduce the risk of penalty. Please see the contract for more information.<br><br>\n";
					$msg .= "Please print this page for your record.<br>\n";
					$msg .= "Your Application Number is <font style='text-decoration:underline;'>" . $application->applyNumber . "</font>.<br>\n";
					$msg .= "If you have any further questions, please contact Anam Global House at <a href=\"mailto:$cf_email_graduate\">$cf_email_graduate</a>.<br><br>\n";
					$msg .= "Korea University<br>\n";
					$msg .= "Anam Global House<br>\n";
					$msg .= "International Residence<br>\n";
					$msg .= "Fax: 82-2-929-3184<br>\n";
					$msg .= "email: <a href=\"mailto:$cf_email_graduate\">$cf_email_graduate</a><br>\n";
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
						$insert = 0;
						$fp = fopen ("$attach_tmp", "r");
						while ($data = fgetcsv($fp, 1000, ",")) {
							if (!$row) {
								$row++;
								continue;
							}
							$row++;
							$email = $data[0]; // �̸���
							$state = $data[1]; // �������� (IW:�Ի��û, DP:�����ݺκг���, DD:�����ݳ���, RA:ȣ�ǹ���, PR:���αⰣ�����û, FP:������κг���, FD:������, FS:���������б�, RR:�����ݹ�ȯ��û, TR:������������û, RD:�����ݹ�ȯ, CF:����������)
							$account = $data[2]; // �������
							$room_prefer = $data[3]; // ���ϴ�ȣ��
							$mate_nm = $data[4]; // �����Ʈ�̸�
							$mate_id = $data[5]; // �����Ʈ�л����̵�
							$mate_dob = $data[6]; // �����Ʈ����
							$match_pre1 = $data[7]; // �ѱ��������⸦����
							$match_pre2 = $data[8]; // �ݿ��ڸ�����
							$match_pre3 = $data[9]; // ������
							$match_pre4 = $data[10]; // �����Ͼ
							$match_pre5 = $data[11]; // ������������
							$match_pre6 = $data[12]; // ����������
							$period = $data[13]; // ü���Ⱓ�ڵ�
							$rate = $data[14]; // �������
							$room = $data[15]; // ȣ��
							$roommate = $data[16]; // Ȯ���ȷ����Ʈ��
							$admin = $data[17]; // �����ڳ�Ʈ
							if ($state == "") $state = "IW";
							if ($match_pre1 != "Y" && $match_pre1 != "N") $match_pre1 = "M";
							if ($match_pre2 != "Y" && $match_pre2 != "N") $match_pre2 = "M";
							if ($match_pre3 != "Y" && $match_pre3 != "N") $match_pre3 = "M";
							if ($match_pre4 != "Y" && $match_pre4 != "N") $match_pre4 = "M";
							if ($match_pre5 != "Y" && $match_pre5 != "N") $match_pre5 = "M";
							if ($match_pre6 != "Y" && $match_pre6 != "N") $match_pre6 = "M";
							if ($mate_dob == "") $mate_dob = "0000-00-00";
							if (!$application->getApplicationNumber(date("Y").date("m"))) $app_no = date("Y"). date("m") . "0001";
							else $app_no = "";
							$flag = $application->insertApplication1($app_no, $email, $state, $account, $room_prefer, $mate_nm, $mate_id, $mate_dob, $match_pre1, $match_pre2, $match_pre3, $match_pre4, $match_pre5, $match_pre6, $checkin, $checkout, $period, $rate, $room, $roommate, $admin);
							if ($flag) {
								$flag = $application->insertPreference($rate, $application->applyNumber);
								if ($rate && $period) $flag = $application->updateResidenceFee($application->applyNumber, $rate, $period);
								if($flag) $insert++;
								else $flag = $application->deleteApplication($application->applyNumber);
							}
						}
						fclose ($fp);
					} else $mode = "no_attach";
					break;
				case "force";
					$cf_no = $_POST["cf_no"];
					$application->getApplicationInfo($no);
					if (!$application->applyNumber) $mode = "no_apply";
					else if ($application->applyState != "FD" && $application->isRefundExist($no)) $mode = "exist_refund";
					else {
						$kind = $application->applyKind;
						$student = $application->personStudentID;
						$room = $application->linkRoomCode;
						$old_period = $application->linkPeriodCode;
						$new_period = $application->getApplicationPeriod($cf_no);
						$fname = $application->personFirstName;
						$mname = $application->personMiddleName;
						$lname = $application->personLastName;
						$dob = $application->personBirthDate;
						$email = $application->personEmail;
						$flag = $application->insertRefund($no, $cf_no, $kind, $student, $fname, $mname, $lname, $dob, $email, $room, $old_period, $new_period);
						if (!$flag) $mode = "error";
					}
					break;
			}

			$application->closeDatabase();
			unset($application);

			if ($mode == "error") {
				echo "<script language=\"javascript\">";
				echo "alert(\"�۾����� �� ������ �߻��Ͽ����ϴ�.\\n\\n���߿� �ٽ� �õ��� �ּ���.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "over") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"�̹��� ���� �뷮�� " . round($max_attach / 1024 / 1024, 0) . "M���Ͽ��� �մϴ�.\\n\\nȮ�� �� �ٽ� �õ��� �ּ���.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "room") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"����� �Ϸ������ ���������� ���½��ϴ�.\");";
				echo "document.location.replace(\"app_view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_kind=$s_kind&s_state=$s_state&s_grade=$s_grade&s_current=$s_current&s_period=$s_period&sort1=$sort1&sort2=$sort2\");";
				echo "</script>";
			} else if ($mode == "upload") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"�� " . ($row - 1) . "�� �� " . $insert . "���� �߰��ϰ� " . ($row - 1 - $insert) . "���� �����߽��ϴ�.\");";
				echo "document.location.replace('app_list.php');";
				echo "</script>";
			} else if ($mode == "exist") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"���� ". $room . "(��)�� �̹� ������� �Ǿ� �ֽ��ϴ�.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "book") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"���� ". $room . "(��)�� �̹� ������ �Ϸ�� �����Դϴ�.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "no_apply") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"�������� �ʴ� �¶��������Դϴ�.\\n\\nȮ���� ���ð� �ٽ� �õ��� �ּ���.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "exist_refund") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"�̹� �̿��Ǿ� �ֽ��ϴ�.\\n\\nȮ���� ���ð� �ٽ� �õ��� �ּ���.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "force") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"������ ���� �̿��� ���������� �̷�������ϴ�.\");";
				echo "document.location.replace(\"app_view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_kind=$s_kind&s_state=$s_state&s_grade=$s_grade&s_current=$s_current&s_period=$s_period&sort1=$sort1&sort2=$sort2\");";
				echo "</script>";
			} else if ($mode == "edit" || $mode == "assign" || $mode == "cancel" || $mode == "pay_new" || $mode == "pay_edit" || $mode == "pay_del") header("Location: app_view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_kind=$s_kind&s_state=$s_state&s_grade=$s_grade&s_current=$s_current&s_period=$s_period&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2");
			else if ($mode == "add" || $mode == "del") header("Location: app_list.php?page=$page&s_type=$s_type&s_text=$s_text&s_kind=$s_kind&s_state=$s_state&s_grade=$s_grade&s_current=$s_current&s_period=$s_period&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2");
			else header("Location: app_list.php");
		}
	}
?>