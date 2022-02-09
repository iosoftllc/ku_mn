<?
	include_once("../common/login_tpl.php");
	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] == 8 || (int)$ihouse_admin_info[grade] < 7) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/facility_tpl.php");
			switch ($mode) {
				case "new":
					$state = $_POST["state"];
					$resident = $_POST["resident"];
					$email = $_POST["email"];
					$phone = $_POST["phone"];
					$event_dt = $_POST["event_dt"];
					$event_h1 = $_POST["event_h1"];
					$event_m1 = $_POST["event_m1"];
					$event_h2 = $_POST["event_h2"];
					$event_m2 = $_POST["event_m2"];
					$attendee = $_POST["attendee"];
					$request1 = $_POST["request1"];
					$request2 = $_POST["request2"];
					$request3 = $_POST["request3"];
					$request4 = $_POST["request4"];
					$request5 = $_POST["request5"];
					$breakfast = $_POST["breakfast"];
					$discount1 = $_POST["discount1"];
					$discount2 = $_POST["discount2"];
					$settle1 = $_POST["settle1"];
					$settle2 = $_POST["settle2"];
					$settle3 = $_POST["settle3"];
					$settle4 = $_POST["settle4"];
					$assign_dt = $_POST["assign_dt"];
					$confirm_dt = $_POST["confirm_dt"];
					$billed_dt = $_POST["billed_dt"];
					$paid_dt = $_POST["paid_dt"];
					$cancel = $_POST["cancel"];
					$cancel_dt = $_POST["cancel_dt"];
					$waive = $_POST["waive"];
					$waive_dt = $_POST["waive_dt"];
					$event = $_POST["event"];
					$event = addslashes($event);
					$event = htmlspecialchars($event);
					$applicant = $_POST["applicant"];
					$applicant = addslashes($applicant);
					$applicant = htmlspecialchars($applicant);
					$department = $_POST["department"];
					$department = addslashes($department);
					$department = htmlspecialchars($department);
					$position = $_POST["position"];
					$position = addslashes($position);
					$position = htmlspecialchars($position);
					$admin = $_POST["admin"];
					$admin = addslashes($admin);
					$admin = htmlspecialchars($admin);
					if (!$state) $state = "IW";
					if ($resident != "Y") $resident = "N";
					if (!is_numeric($attendee)) $attendee = 0;
					if ($breakfast != "Y") $breakfast = "N";
					if ($discount1 != "Y") $discount1 = "N";
					if ($discount2 != "Y") $discount2 = "N";
					if ($settle1 != "Y") $settle1 = "N";
					if ($settle2 != "Y") $settle2 = "N";
					if ($settle3 != "Y") $settle3 = "N";
					if ($settle4 != "Y") $settle4 = "N";
					if ($request1 != "C1") $request1 = "";
					if ($request2 != "S1") $request2 = "";
					if ($request3 != "S2") $request3 = "";
					if ($request4 != "R1") $request4 = "";
					if ($request5 != "R2") $request5 = "";
					$event_hr = $event_h1 . "|" . $event_m1 . "|" .  $event_h2 . "|" .  $event_m2;
					$request = $request1 . "|" . $request2 . "|" . $request3 . "|" . $request4 . "|" . $request5;
					if (!is_numeric($cancel)) $cancel = 0;
					if ($cancel_dt == "") $cancel_dt = "0000-00-00";
					if (!is_numeric($waive)) $waive = 0;
					if ($waive_dt == "") $waive_dt = "0000-00-00";
					if (trim($event_dt) == "" || (trim($phone) != "" && !is_numeric(preg_replace("/-/", "", trim($phone))))) $mode = "error";
					else if (!$facility->isRoomAvailable($no, $request1, $request2, $request3, $request4, $request5, $event_dt, $event_h1."|".$event_m1, $event_h2."|".$event_m2)) $mode = "book";
					else {
						$fee = $facility->calculateFee($request1, $request2, $request3, $request4, $request5, $event_h1, $event_m1, $event_h2, $event_m2, $breakfast, $discount1, $discount2);
						$meal = $facility->calculateMeal($attendee, $breakfast);
						if (!$facility->getFacilityNumber(date("Y").date("m"))) $facility_no = date("Y"). date("m") . "0001";
						$flag = $facility->insertFacility($facility_no, $state, $event, $applicant, $resident, $department, $position, $email, $phone, $event_dt, $event_hr, $attendee, $request, $fee, $meal, $cancel, $waive, $breakfast, $discount1, $discount2, $settle1, $settle2, $settle3, $settle4, $assign_dt, $confirm_dt, $billed_dt, $paid_dt, $cancel_dt, $waive_dt, $admin);
						if ($flag) $flag = $facility->approveFacility($facility_no, $ihouse_admin_info[grade], "Y");
						else $mode = "error";
					}
					break;
				case "edit":
					$state = $_POST["state"];
					$resident = $_POST["resident"];
					$email = $_POST["email"];
					$phone = $_POST["phone"];
					$event_dt = $_POST["event_dt"];
					$event_h1 = $_POST["event_h1"];
					$event_m1 = $_POST["event_m1"];
					$event_h2 = $_POST["event_h2"];
					$event_m2 = $_POST["event_m2"];
					$attendee = $_POST["attendee"];
					$request1 = $_POST["request1"];
					$request2 = $_POST["request2"];
					$request3 = $_POST["request3"];
					$request4 = $_POST["request4"];
					$request5 = $_POST["request5"];
					$breakfast = $_POST["breakfast"];
					$discount1 = $_POST["discount1"];
					$discount2 = $_POST["discount2"];
					$settle1 = $_POST["settle1"];
					$settle2 = $_POST["settle2"];
					$settle3 = $_POST["settle3"];
					$settle4 = $_POST["settle4"];
					$assign_dt = $_POST["assign_dt"];
					$confirm_dt = $_POST["confirm_dt"];
					$billed_dt = $_POST["billed_dt"];
					$paid_dt = $_POST["paid_dt"];
					$cancel = $_POST["cancel"];
					$cancel_dt = $_POST["cancel_dt"];
					$waive = $_POST["waive"];
					$waive_dt = $_POST["waive_dt"];
					$event = $_POST["event"];
					$event = addslashes($event);
					$event = htmlspecialchars($event);
					$applicant = $_POST["applicant"];
					$applicant = addslashes($applicant);
					$applicant = htmlspecialchars($applicant);
					$department = $_POST["department"];
					$department = addslashes($department);
					$department = htmlspecialchars($department);
					$position = $_POST["position"];
					$position = addslashes($position);
					$position = htmlspecialchars($position);
					$admin = $_POST["admin"];
					$admin = addslashes($admin);
					$admin = htmlspecialchars($admin);
					if (!$state) $state = "IW";
					if ($resident != "Y") $resident = "N";
					if (!is_numeric($attendee)) $attendee = 0;
					if ($breakfast != "Y") $breakfast = "N";
					if ($discount1 != "Y") $discount1 = "N";
					if ($discount2 != "Y") $discount2 = "N";
					if ($settle1 != "Y") $settle1 = "N";
					if ($settle2 != "Y") $settle2 = "N";
					if ($settle3 != "Y") $settle3 = "N";
					if ($settle4 != "Y") $settle4 = "N";
					if ($request1 != "C1") $request1 = "";
					if ($request2 != "S1") $request2 = "";
					if ($request3 != "S2") $request3 = "";
					if ($request4 != "R1") $request4 = "";
					if ($request5 != "R2") $request5 = "";
					$event_hr = $event_h1 . "|" . $event_m1 . "|" .  $event_h2 . "|" .  $event_m2;
					$request = $request1 . "|" . $request2 . "|" . $request3 . "|" . $request4 . "|" . $request5;
					if (!is_numeric($cancel)) $cancel = 0;
					if ($cancel_dt == "") $cancel_dt = "0000-00-00";
					if (!is_numeric($waive)) $waive = 0;
					if ($waive_dt == "") $waive_dt = "0000-00-00";
					if (trim($event_dt) == "" || (trim($phone) != "" && !is_numeric(preg_replace("/-/", "", trim($phone))))) $mode = "error";
					else if (!$facility->isRoomAvailable($no, $request1, $request2, $request3, $request4, $request5, $event_dt, $event_h1."|".$event_m1, $event_h2."|".$event_m2)) $mode = "book";
					else {
						$fee = $facility->calculateFee($request1, $request2, $request3, $request4, $request5, $event_h1, $event_m1, $event_h2, $event_m2, $breakfast, $discount1, $discount2);
						$meal = $facility->calculateMeal($attendee, $breakfast);
						$flag = $facility->updateFacility($no, $state, $event, $applicant, $resident, $department, $position, $email, $phone, $event_dt, $event_hr, $attendee, $request, $fee, $meal, $cancel, $waive, $breakfast, $discount1, $discount2, $settle1, $settle2, $settle3, $settle4, $assign_dt, $confirm_dt, $billed_dt, $paid_dt, $cancel_dt, $waive_dt, $admin);
						if ($flag) $flag = $facility->approveFacility($no, $ihouse_admin_info[grade], "Y");
						else $mode = "error";
					}
					break;
				case "del":
					$arr_no = explode(",", $no);
					for ($i = 0; $i < count($arr_no); $i++) {
						$flag = $facility->deleteFacility($arr_no[$i]);
						if (!$flag) {
							$mode = "error";
							break;
						} 
					}
					break;
				case "copy":
					$flag = $facility->copyFacility($no);
					if (!$flag) $mode = "error";
					break;
				case "room";
					include_once("../../lib/class.rFastTemplate.php");
					$facility->getFacilityInfo($no);
					$temp = explode("|", $facility->facilityEventHour);
					if ($temp[0] && $temp[2]) {
						$event_hr = $temp[0] . ":" . $temp[1] . " ~ " . $temp[2] . ":" . $temp[3] . " (" . $facility->calculateTime($temp[0], $temp[1], $temp[2], $temp[3]) . " hours)";
					} else $event_hr = "";
					$from = $ihouse_admin_info[name] . "<" . $ihouse_admin_info[email] . ">";
					$to = $facility->facilityEmail;
					$subject = "[KU Residence Life] Assignment & Payment Information";
					$msg = "Dear " . $facility->facilityApplicant . ",<br><br>\n";
					$msg .= "Thank you for your application.<br>\n";
					$msg .= "Your reservation is confirmed:<br><br>\n";
					$msg .= "<b>* Application Number : " . $facility->facilityNumber . "<br>\n";
					$msg .= "* Room Number : " . $facility->getRequestValue1($facility->facilityRequest) . "<br>\n";
					$msg .= "* Date of Event : " . $facility->facilityEventDate . "<br>\n";
					$msg .= "* Hours of Event : " . $event_hr . "<br>\n";
					$msg .= "* Rate : KR " . number_format($facility->facilityFee) . "</b><br><br>\n";
					$msg .= "The amount should be wired to our bank account before your event.<br>\n";
					$msg .= "Please note that Korea University Anam Residence Life Office does not accept cash or credit card.<br><br>\n";
					$msg .= "Our bank information is as follows:<br>\n";
					$msg .= "<b>BANK: Hana Bank, Godae Branch<br>\n";
					if ($facility->facilityBreakfast == "Y") $msg .= "RECIPIENT: CJ CAFETERIA<br>\n";
					else $msg .= "RECIPIENT: Korea University Anam Residence Life<br>\n";
					$msg .= "SWIFT CODE: HNBNKRSE<br>\n";
					if ($facility->facilityBreakfast == "Y") $msg .= "ACCOUNT NO.: 391-910007-48204</b><br><br>\n";
					else $msg .= "ACCOUNT NO.: 391-910001-03204</b><br><br>\n";
					$msg .= "Please make sure to write your name of event or organization in the reference field for Recipient.<br>\n";
					$msg .= "Thank you and we look forward to seeing you soon.<br>\n";
					$msg .= "Sincerely,<br><br>\n";
					$msg .= "Korea University<br>\n";
					$msg .= "Anam Residence Life<br>\n";
					$msg .= "International Residence<br>\n";
					$msg .= "Anam-Dong Seongbuk-Gu Seoul, 136-701 Korea<br>\n";
					//$msg .= "Tel: 82-2-3290-1555<br>\n";
					$msg .= "Fax: 82-2-926-3464<br>\n";
					$msg .= "<a href=\"mailto:$cf_email_faculty\">Email: $cf_email_faculty</a>";
					$flag = sendEmail($to, $from, $subject, $msg);
					if (!$flag) $mode = "error";
					break;
				case "invoice";
					include_once("../../lib/class.rFastTemplate.php");
					$tpl = new rFastTemplate("../../tpl/popup");
					$tpl->define(array(body => "invoice_h.html"));
					$tpl->define_dynamic(array(breakfast_row => "body",
					                           waive_row     => "body"));
					$facility->getFacilityInfo($no);
					$hour = explode("|", $facility->facilityEventHour);
					if ($facility->facilityBreakfast == "Y") $title = "CONFERENCE BREAKFAST PACKAGE";
					else $title = "HALL BASE RENT";
					if ($facility->facilityBreakfast == "Y") {
						$acc_no = "391-910007-48204";
						$acc_re = "CJ CAFETERIA";
					} else {
						$acc_no = "391-910001-03204";
						$acc_re = "Korea University Anam Residence Life";
					}
					$tpl->assign(array(INVOICE_NUMBER    => $no,
					                   INVOICE_DATE      => $facility->facilityBilled,
					                   INVOICE_TO        => stripslashes($facility->facilityEventName),
					                   INVOICE_TOTAL     => number_format((int)$facility->facilityFee + (int)$facility->facilityMeal - (int)$facility->facilityWaive),
					                   INVOICE_UNIT      => $facility->getUnitValue($facility->facilityRequest),
					                   INVOICE_CHECKIN   => $facility->facilityEventDate . "<br>" . $hour[0] . ":" . $hour[1],
					                   INVOICE_CHECKOUT  => $facility->facilityEventDate . "<br>" . $hour[2] . ":" . $hour[3],
					                   PAYMENT_DATE      => $facility->facilityAssign,
					                   PAYMENT_TITLE     => $title,
					                   PAYMENT_AMOUNT    => number_format((int)$facility->facilityFee + (int)$facility->facilityMeal),
					                   PAYMENT_BREAKFAST => number_format($facility->facilityMeal),
					                   ACCOUNT_NUMBER    => $acc_no,
					                   ACCOUNT_RECIPIENT => $acc_re));
					include("../common/variables_tpl.php");
					if ((int)$facility->facilityWaive > 0) {
						$tpl->assign(array(WAIVE_DATE   => $facility->facilityWaiveDate,
						                   WAIVE_AMOUNT => number_format($facility->facilityWaive)));
						$tpl->parse(WAIVE_ROWS, ".waive_row");
					}
					//if ((int)$facility->facilityMeal > 0) $tpl->parse(BREAKFAST_ROWS, ".breakfast_row");
					$tpl->parse(FINAL, "body");
					$msg = $tpl->GetTemplate(FINAL);
					unset($tpl);
					$from = $ihouse_admin_info[name] . "<" . $ihouse_admin_info[email] . ">";
					//$to = $name . "<" . $facility->facilityEmail . ">";
					$to = $facility->facilityEmail;
					$subject = "[KU Residence Life] INVOICE";
					$flag = sendEmail($to, $from, $subject, $msg);
					if (!$flag) $mode = "error";
					break;
				case "receipt";
					include_once("../../lib/class.rFastTemplate.php");
					$tpl = new rFastTemplate("../../tpl/popup");
					$tpl->define(array(body => "receipt_h.html"));
					$tpl->define_dynamic(array(rent_row      => "body",
					                           breakfast_row => "body",
					                           cancel_row    => "body"));
					$facility->getFacilityInfo($no);
					$hour = explode("|", $facility->facilityEventHour);
					if ($facility->facilityBreakfast == "Y") $title = "CONFERENCE BREAKFAST PACKAGE";
					else $title = "HALL BASE RENT";
					/*
					$total = 0;
					for ($i = 0; $i < count($item); $i++) {
						$tpl->assign(array(PAYMENT_DATE     => $facility->facilityPaid,
						                   PAYMENT_AMOUNT    => number_format($facility->facilityFee),
						                   PAYMENT_BREAKFAST => number_format($facility->facilityMeal)));
						if ($item[$i] == "R") {
							$total += (int)$facility->facilityFee;
							$tpl->parse(RENT_ROWS, ".rent_row");
						} else if ($item[$i] == "B") {
							$total += (int)$facility->facilityMeal;
							$tpl->parse(BREAKFAST_ROWS, ".breakfast_row");
						}
					}
					*/
					if ($facility->facilityCancelDate != "0000-00-00" && is_numeric($facility->facilityCancel) && (int)$facility->facilityCancel > 0) {
						$tpl->assign(array(CANCEL_DATE   => $facility->facilityCancelDate,
						                   CANCEL_AMOUNT => "-" . number_format($facility->facilityCancel)));
						$tpl->parse(CANCEL_ROWS, ".cancel_row");
					}
					$tpl->assign(array(INVOICE_NUMBER   => $no,
					                   INVOICE_DATE     => $facility->facilityBilled,
					                   INVOICE_TO       => stripslashes($facility->facilityEventName),
					                   INVOICE_TOTAL    => number_format((int)$facility->facilityFee + (int)$facility->facilityMeal - (int)$facility->facilityCancel),
					                   INVOICE_UNIT     => $facility->getUnitValue($facility->facilityRequest),
					                   INVOICE_CHECKIN  => $facility->facilityEventDate . "<br>" . $hour[0] . ":" . $hour[1],
					                   INVOICE_CHECKOUT => $facility->facilityEventDate . "<br>" . $hour[2] . ":" . $hour[3],
					                   PAYMENT_DATE     => $facility->facilityPaid,
					                   PAYMENT_TITLE    => $title,
					                   PAYMENT_AMOUNT   => number_format((int)$facility->facilityFee + (int)$facility->facilityMeal)));
					include("../common/variables_tpl.php");
					$tpl->parse(FINAL, "body");
					$msg = $tpl->GetTemplate(FINAL);
					unset($tpl);
					$from = $ihouse_admin_info[name] . "<" . $ihouse_admin_info[email] . ">";
					//$to = $name . "<" . $facility->facilityEmail . ">";
					$to = $facility->facilityEmail;
					//$to = "shkim@intia.co.nz";
					$subject = "[KU Residence Life] RECEIPT";
					$flag = sendEmail($to, $from, $subject, $msg);
					if (!$flag) $mode = "error";
					break;
			}
			$facility->closeDatabase();
			unset($facility);
			if ($mode == "error") {
				echo "<script language=\"javascript\">";
				echo "alert(\"작업수행 중 오류가 발생하였습니다.\\n\\n나중에 다시 시도해 주세요.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "book") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"이미 예약이 완료된 상태입니다.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "room") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"룸배정 완료메일을 성공적으로 보냈습니다.\");";
				echo "self.close();";
				echo "</script>";
			} else if ($mode == "invoice") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"인보이스 메일을 성공적으로 보냈습니다.\");";
				echo "self.close();";
				echo "</script>";
			} else if ($mode == "receipt") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"영수증 메일을 성공적으로 보냈습니다.\");";
				echo "self.close();";
				echo "</script>";
			} else if ($mode == "copy") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"시설예약을 성공적으로 복사하였습니다.\");";
				echo "document.location.replace(\"fac_list.php?page=$page&s_type=$s_type&s_text=$s_text&s_state=$s_state&s_grade=$s_grade&s_room=$s_room&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2\");";
				echo "</script>";
			} else if ($mode == "edit") header("Location: fac_view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_state=$s_state&s_grade=$s_grade&s_room=$s_room&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2");
			else if ($mode == "del") header("Location: fac_list.php?page=$page&s_type=$s_type&s_text=$s_text&s_state=$s_state&s_grade=$s_grade&s_room=$s_room&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2");
			else header("Location: fac_list.php");
		}
	}
?>