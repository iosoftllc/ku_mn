<?
	include_once("../../lib/conf.common.php");
	include_once("../common/faculty_tpl.php");

	switch ($mode) {
		case "apply":
			$arrival = $_POST["arr_dt"];
			$departure = $_POST["det_dt"];
			$title = $_POST["title"];
			$email = $_POST["email"];
			$phone = $_POST["phone"];
			$pay = $_POST["pay"];
			$remail = $_POST["remail"];
			$rphone = $_POST["rphone"];
			$rate = $_POST["rate"];
			$dob_yy = $_POST["dob_yy"];
			$dob_mm = $_POST["dob_mm"];
			$dob_dd = $_POST["dob_dd"];
			$affiliate = $_POST["affiliate"];
			$no_room = $_POST["no_room"];
			$lname = $_POST["lname"];
			$lname = addslashes($lname);
			$lname = htmlspecialchars($lname);
			$fname = $_POST["fname"];
			$fname = addslashes($fname);
			$fname = htmlspecialchars($fname);
			$mname = $_POST["mname"];
			$mname = addslashes($mname);
			$mname = htmlspecialchars($mname);
			$rlname = $_POST["rlname"];
			$rlname = addslashes($rlname);
			$rlname = htmlspecialchars($rlname);
			$rfname = $_POST["rfname"];
			$rfname = addslashes($rfname);
			$rfname = htmlspecialchars($rfname);
			$rmname = $_POST["rmname"];
			$rmname = addslashes($rmname);
			$rmname = htmlspecialchars($rmname);
			$name_kr = $_POST["name_kr"];
			$name_kr = addslashes($name_kr);
			$name_kr = htmlspecialchars($name_kr);
			$kdepart = $_POST["kdepart"];
			$kdepart = addslashes($kdepart);
			$kdepart = htmlspecialchars($kdepart);
			$kpos = $_POST["kpos"];
			$kpos = addslashes($kpos);
			$kpos = htmlspecialchars($kpos);
			$hdepart = $_POST["hdepart"];
			$hdepart = addslashes($hdepart);
			$hdepart = htmlspecialchars($hdepart);
			$hpos = $_POST["hpos"];
			$hpos = addslashes($hpos);
			$hpos = htmlspecialchars($hpos);
			$rdepart = $_POST["rdepart"];
			$rdepart = addslashes($rdepart);
			$rdepart = htmlspecialchars($rdepart);
			$rpos = $_POST["rpos"];
			$rpos = addslashes($rpos);
			$rpos = htmlspecialchars($rpos);
			$employ = $_POST["employ"];
			$employ = addslashes($employ);
			$employ = htmlspecialchars($employ);
			$purpose = $_POST["purpose"];
			$purpose = addslashes($purpose);
			$purpose = htmlspecialchars($purpose);
			$nation = $_POST["nation"];
			$nation = addslashes($nation);
			$nation = htmlspecialchars($nation);
			$country = $_POST["country"];
			$country = addslashes($country);
			$country = htmlspecialchars($country);
			$request = $_POST["request"];
			$request = addslashes($request);
			$request = htmlspecialchars($request);
			$admin = $_POST["admin"];
			$admin = addslashes($admin);
			$admin = htmlspecialchars($admin);
			if ($title != "Ms" && $title != "Mrs") $title = "Mr";
			if ($pay != "S" && $pay != "R") $pay = "N";
			if ($affiliate != "N") $affiliate = "Y";
			if (!is_numeric($no_room)) $no_room = 1;
			if ($dob_yy && $dob_mm && $dob_dd) $dob = $dob_yy . "-" . $dob_mm . "-" . $dob_dd;
			else $dob = "0000-00-00";
			if (!$faculty->getFacultyNumber(date("Y").date("m"))) $faculty_no = date("Y"). date("m") . "0001";
			else $faculty_no = "";
			$count_dd = 0;
			$count_mm = 0;
			$count_temp = 1;
			$count_flag = true;
			$count_total = dateDiff($arrival, $departure);
			while ($count_flag) {
				$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($arrival, 5, 2) + $count_temp, substr($arrival, 8, 2), substr($arrival, 0, 4)));
				if ($departure < $temp_dt) {
					$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($arrival, 5, 2) + $count_temp - 1, substr($arrival, 8, 2), substr($arrival, 0, 4)));
					$count_dd = dateDiff($temp_dt, $departure);
					$count_flag = false;
				} else {
					$count_mm++;
					$count_temp++;
				}
			}
			if (($rate == "STUDIO2" || $rate == "1BED" || $rate == "2BED" || $rate == "DEPART") && $affiliate == "N") $mode = "none";
			else if (($rate == "TRIPLE" || $rate == "QUAD" || $rate == "QUINT" || $rate == "OCTET" || $rate == "HANDICAP") && $affiliate == "N") $mode = "none";
			else if (($rate == "STUDIO2" || $rate == "1BED" || $rate == "2BED") && $count_mm == 0) $mode = "less";
			else {
				$flag = $faculty->insertFaculty($faculty_no, $title, $lname, $fname, $mname, $name_kr, $employ, $purpose, $kdepart, $kpos, $hdepart, $hpos, $nation, $dob, $country, $email, $phone, $arrival, $departure, $affiliate, $no_room, $pay, $rlname, $rfname, $rmname, $rdepart, $rpos, $remail, $rphone, $rate, $request, $admin);
				if ($flag) {
					$view_no = $faculty->facultyNumber;
					$faculty->calculateFee1($view_no, $rate, $arrival, $departure, $no_room);
					//$faculty->calculateFee($rate, $affiliate, $count_dd, $count_mm, $count_total);
					$rate_type = $faculty->feeType;
					$rate_pr = (int)$faculty->feeRate;
					//$deposit = (int)$faculty->feeDeposit * $no_room;
					//$rental = (int)$faculty->feeRental * $no_room;
					//$flag = $faculty->updateDepositFee($view_no, $deposit);
					//$flag = $faculty->updateRentalFee($view_no, $rental);
					include_once("../../lib/class.rFastTemplate.php");
					$unit = $faculty->getRateValue($rate);
					$from = $cf_email_faculty;
					$to = $email;
					$subject = "[KU Residence Life] Acknowledgment of Housing Application Receipt";
					$msg = "Dear $title. $lname,<br><br>\n";
					$msg .= "Thank you for applying for Korea University Housing.<br><br>";
					$msg .= "We wanted to let you know that we are in the process of reviewing applications.<br><br>\n";
					$msg .= "Housing Application Number : $view_no<br><br>\n";
					$msg .= "Check-in Date : $arrival<br>\n";
					$msg .= "Check-out Date : $departure<br>\n";
					$msg .= "Unit Type Applied for : $unit (";
					if ($rate_type == "mm") $msg .= "Rate per Month : KRW ";
					else $msg .= "Rate per Night : KRW ";
					$msg .= number_format($rate_pr) . ")<br><br>\n";
					$msg .= "No. of Rooms Applied for : $no_room<br><br>\n";
					//$msg .= "Total Rate : KRW " . number_format($rental) . " (No. of Rooms Applied for * Rate per Night/Month * Nights/Months)<br><br>\n";
					$msg .= "If you wish to make changes to your application form, please submit a second application form.<br><br>\n";
					$msg .= "Also you may e-mail the requested changes to us at: " . $cf_email_faculty . ".<br><br>\n";
					$msg .= "<font color='red'>*** This application confirmation letter does not mean the confirmation of the room assignment. In other words, according to the room availability, the room assignment will not be made in the future.</font><br><br>\n";
					$msg .= "You will be sent your room assignment and invoice within 1~2 weeks before check-in date.<br><br>\n";
					$msg .= "Thank you.<br><br>";
					$msg .= "Dear $title. $lname,<br><br>\n";
					$msg .= "��û�� �ּż� �����մϴ�.<br><br>";
					$msg .= "��û�Ͻ� ���뿡 ����, �Ʒ��� ���� �ٽ� �˷��帮���� Ȯ���غ��ñ� �ٶ��ϴ�.<br><br>\n";
					$msg .= "��û ��ȣ : $view_no<br><br>\n";
					$msg .= "�Խ� ��¥ : $arrival<br>\n";
					$msg .= "��� ��¥ : $departure<br>\n";
					$msg .= "��û�� ���� ���� : $unit (";
					if ($rate_type == "mm") $msg .= "�⺻ ���� : KRW ";
					else $msg .= "�⺻ ���� : KRW ";
					$msg .= number_format($rate_pr) . ")<br><br>\n";
					$msg .= "��û�� ���� �� : $no_room<br><br>\n";
					//$msg .= "�� ���� : KRW " . number_format($rental) . " (No. of Rooms Applied for * Rate per Night/Month * Nights/Months)<br><br>\n";
					$msg .= "��û�Ͻ� ���뿡 ������ �ʿ��Ͻø�, �ٽ� �¶������� ��û�� �Ͻðų�, " . $cf_email_faculty . "�� ������ ������ �̿��Ϸ� �����ø� �˴ϴ�.<br><br>\n";
					$msg .= "<font color='red'>***���� �߼۵� ���� Ȯ�� ������ ����� Ȯ�� ������ �ƴմϴ�. ������ �Ǵ���, ����� ��Ȳ�� ����, ������� ���� ���� �� �ֽ��ϴ�.</font><br><br>\n";
					$msg .= "����Ȯ�μ��� û������ �Խ��Ͻñ� 1~2�� �� �̳��� ������ �� �ֽ��ϴ�.<br><br>\n";
					$msg .= "�����մϴ�.<br><br>";
					$flag = sendEmail($to, $from, $subject, $msg);
				} else $mode = "error";
			}
			break;
	}
	$faculty->closeDatabase();
	unset($faculty);
		
	if ($mode == "error") {
		echo "<script language=\"javascript\">";
		echo "alert(\"Unexpected error is occured.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "none") {
		echo "<script langauage=\"javascript\">";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "less") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Int'l Fac.Housing is limited to Long term residents(over 1 month).\\n\\nInt'l Fac.Housing�� �� �� �̻� ��� ����ڸ� ��û �����մϴ�.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($mode == "apply") {
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Thank you. Your online application is successfully registered.\");";
		echo "document.location.replace(\"../../src/faculty/view.php?view_no=$view_no&view_fname=$fname&view_mname=$mname&view_lname=$lname\");";
		echo "</script>";
	} else header("Location: " . $url_page . "intro_f");
?>