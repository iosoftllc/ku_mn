<?
	include_once("../../lib/conf.common.php");
	include_once("../common/facility_tpl.php");

	switch ($mode) {
		case "apply":
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
			if ($breakfast != "Y") $breakfast = "N";
			if ($resident != "Y") $resident = "N";
			if (!is_numeric($attendee)) $attendee = 0;
			if ($request1 != "C1") $request1 = "";
			if ($request2 != "S1") $request2 = "";
			if ($request3 != "S2") $request3 = "";
			if ($request4 != "R1") $request4 = "";
			if ($request5 != "R2") $request5 = "";
			$event_hr = $event_h1 . "|" . $event_m1 . "|" .  $event_h2 . "|" .  $event_m2;
			$request = $request1 . "|" . $request2 . "|" . $request3 . "|" . $request4 . "|" . $request5;
			if (trim($event_dt) == "" || (trim($phone) != "" && !is_numeric(preg_replace("/-/", "", trim($phone))))) $mode = "error";
			else if (!$facility->isRoomAvailable($request1, $request2, $request3, $request4, $request5, $event_dt, $event_h1."|".$event_m1, $event_h2."|".$event_m2)) $mode = "book";
			else {
				$fee = $facility->calculateFee($request1, $request2, $request3, $request4, $request5, $event_h1, $event_m1, $event_h2, $event_m2, $breakfast);
				$meal = $facility->calculateMeal($attendee, $breakfast);
				if (!$facility->getFacilityNumber(date("Y").date("m"))) $facility_no = date("Y"). date("m") . "0001";
				$flag = $facility->insertFacility($facility_no, $event, $applicant, $resident, $department, $position, $email, $phone, $event_dt, $event_hr, $attendee, $request, $breakfast, $fee, $meal);
				if (!$flag) $mode = "error";
				if ($flag) {
					$view_no = $facility->facilityNumber;
					/*
					include_once("../../lib/class.rFastTemplate.php");
					$unit = $facility->getRateValue($rate);
					$from = $ihouse_admin_info[name] . "<" . $ihouse_admin_info[email] . ">";
					$to = $email;
					$subject = "[KU Residence Life] Acknowledgment of Housing Application Receipt";
					$msg = "Dear Mr./Ms. $lname,<br><br>\n";
					$msg .= "Thank you for applying for Korea University Housing. We wanted to let you know that we are in the process of reviewing applications.<br><br>\n";
					$msg .= "Housing Application Number : $view_no<br>\n";
					$msg .= "Check-in Date : $arrival<br>\n";
					$msg .= "Check-out Date : $departure<br>\n";
					$msg .= "Unit Type Applied for : $unit<br>\n";
					$msg .= "No. of Rooms Applied for: $no_room<br>\n";
								$msg .= "Rate per Night : KRW 000,000<br>\n";
								$msg .= "Total Rate: KRW 0000,000 (No. of Rooms Applied for * Rate per Night * Nights)<br><br>\n";
								$msg .= "If you wish to make changes to your application form, please submit a second application form.<br><br>\n";
								$msg .= "Also you may e-mail the requested changes to us at: $cf_email_facility.<br><br>\n";
								$msg .= "<font color='red'>*** This application confirmation letter does not mean the confirmation of the room assignment. In other words, according to the room availability, the room assignment will not be made in the future.</font><br><br>\n";
								$msg .= "You will be sent your room assignment and invoice within 1~2 weeks before check-in date.<br><br>\n";
								$msg .= "Thank you.<br><br>";
								$flag = sendEmail($to, $from, $subject, $msg);
					*/
				} else $mode = "error";
			}
			break;
	}
	$facility->closeDatabase();
	unset($facility);
		
	if ($mode == "error") {
		echo "<script language=\"javascript\">";
		echo "alert(\"Unexpected error is occured.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "book") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Sorry!!! The room you select is already booked.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "apply") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Thank you. Your online application is successfully registered.\");";
		echo "document.location.replace(\"../../src/facility/view.php?view_no=$view_no&view_event=$event\");";
		echo "</script>";
	} else header("Location: " . $url_page . "facility");
?>