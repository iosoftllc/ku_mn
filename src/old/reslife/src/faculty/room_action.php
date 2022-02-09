<?
	include_once("../common/login_tpl.php");
	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] == 8 || (int)$ihouse_admin_info[grade] < 7) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/faculty_tpl.php");
			switch ($mode) {
				case "new":
					$arrival = $_POST["arr_dt"];
					$departure = $_POST["det_dt"];
					$state = $_POST["state"];
					$title = $_POST["title"];
					$email = $_POST["email"];
					$phone = $_POST["phone"];
					$pay = $_POST["pay"];
					$remail = $_POST["remail"];
					$rphone = $_POST["rphone"];
					$settle1 = $_POST["settle1"];
					$settle2 = $_POST["settle2"];
					$settle3 = $_POST["settle3"];
					$settle4 = $_POST["settle4"];
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
					if (!$state) $state = "IW";
					if ($title != "Ms" && $title != "Mrs") $title = "Mr";
					if ($pay != "S" && $pay != "R") $pay = "N";
					if ($settle1 != "Y") $settle1 = "N";
					if ($settle2 != "Y") $settle2 = "N";
					if ($settle3 != "Y") $settle3 = "N";
					if ($settle4 != "Y") $settle4 = "N";
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
					else if (($rate == "STUDIO2" || $rate == "1BED" || $rate == "2BED") && $count_mm == 0) $mode = "less";
					else {
						$flag = $faculty->insertFaculty($faculty_no, $state, $title, $lname, $fname, $mname, $name_kr, $employ, $purpose, $kdepart, $kpos, $hdepart, $hpos, $nation, $dob, $country, $email, $phone, $arrival, $departure, $affiliate, $no_room, $pay, $rlname, $rfname, $rmname, $rdepart, $rpos, $remail, $rphone, $settle1, $settle2, $settle3, $settle4, $rate, $request, $admin);
						if ($flag) $flag = $faculty->approveFaculty($faculty_no, $ihouse_admin_info[grade], "Y");
						else $mode = "error";
					}
					break;
				case "edit":
					$arrival = $_POST["arr_dt"];
					$departure = $_POST["det_dt"];
					$state = $_POST["state"];
					$title = $_POST["title"];
					$email = $_POST["email"];
					$phone = $_POST["phone"];
					$pay = $_POST["pay"];
					$remail = $_POST["remail"];
					$rphone = $_POST["rphone"];
					$settle1 = $_POST["settle1"];
					$settle2 = $_POST["settle2"];
					$settle3 = $_POST["settle3"];
					$settle4 = $_POST["settle4"];
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
					if (!$state) $state = "IW";
					if ($title != "Ms" && $title != "Mrs") $title = "Mr";
					if ($pay != "S" && $pay != "R") $pay = "N";
					if ($settle1 != "Y") $settle1 = "N";
					if ($settle2 != "Y") $settle2 = "N";
					if ($settle3 != "Y") $settle3 = "N";
					if ($settle4 != "Y") $settle4 = "N";
					if ($affiliate != "N") $affiliate = "Y";
					if (!is_numeric($no_room)) $no_room = 1;
					if ($dob_yy && $dob_mm && $dob_dd) $dob = $dob_yy . "-" . $dob_mm . "-" . $dob_dd;
					else $dob = "0000-00-00";
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
					else if (($rate == "STUDIO2" || $rate == "1BED" || $rate == "2BED") && $count_mm == 0) $mode = "less";
					else {
						$flag = $faculty->updateFaculty($no, $state, $title, $lname, $fname, $mname, $name_kr, $employ, $purpose, $kdepart, $kpos, $hdepart, $hpos, $nation, $dob, $country, $email, $phone, $arrival, $departure, $affiliate, $no_room, $pay, $rlname, $rfname, $rmname, $rdepart, $rpos, $remail, $rphone, $settle1, $settle2, $settle3, $settle4, $rate, $request, $admin);
						if ($flag) $faculty->approveFaculty($no, $ihouse_admin_info[grade], "Y");
						else $mode = "error";
					}
					break;
				case "del":
					$arr_no = explode(",", $no);
					for ($i = 0; $i < count($arr_no); $i++) {
						$flag = $faculty->deleteFaculty($arr_no[$i]);
						if (!$flag) {
							$mode = "error";
							break;
						} 
					}
					break;
				case "discount":
					$discount = $_POST["discount"];
					if ($discount != "Y") $discount = "N";
					$flag = $faculty->setDiscount($no, $discount);
					if ($flag) {
						$faculty->getFacultyInfo($no);
						$rate = $faculty->facultyRate;
						$arrival = $faculty->facultyArrival;
						$departure = $faculty->facultyDeparture;
						$discount = $faculty->facultyDiscount;
						$faculty->calculateFee1($no, $rate, $arrival, $departure, $discount);
					} else $mode = "error";
					break;
				case "rm_new":
					$room_new = $_POST["room_new"];
					if ($faculty->isRoomExist($no, $room_new)) $mode = "exist";
					else if (!$faculty->isRoomAvailable($no, $room_new)) $mode = "book";
					else {
						$flag = $faculty->insertRoom($no, $room_new);
						if ($flag) {
							$faculty->getFacultyInfo($no);
							$rate = $faculty->facultyRate;
							$arrival = $faculty->facultyArrival;
							$departure = $faculty->facultyDeparture;
							$affiliate = $faculty->facultyAffiliate;
							$discount = $faculty->facultyDiscount;
							/*
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
							$faculty->calculateFee($rate, $affiliate, $count_dd, $count_mm, $count_total);
							$room_cnt = $faculty->getRoomCount($no);
							$deposit = (int)$faculty->feeDeposit * $room_cnt;
							$rental = (int)$faculty->feeRental * $room_cnt;
							$flag = $faculty->updateDepositFee($no, $deposit);
							$flag = $faculty->updateRentalFee($no, $rental);
							*/
							$faculty->calculateFee1($no, $rate, $arrival, $departure, $discount);
							$flag = $faculty->updateFacultyState($no, "AS");
							$faculty->approveFaculty($no, $ihouse_admin_info[grade], "Y");
						} else $mode = "error";
					}
					break;
				case "rm_del":
					$room_del = $_POST["room_del"];
					$flag = $faculty->deleteRoom($no, $room_del);
					if ($flag) {
							$faculty->getFacultyInfo($no);
							$rate = $faculty->facultyRate;
							$arrival = $faculty->facultyArrival;
							$departure = $faculty->facultyDeparture;
							$affiliate = $faculty->facultyAffiliate;
							$discount = $faculty->facultyDiscount;
							/*
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
							$faculty->calculateFee($rate, $affiliate, $count_dd, $count_mm, $count_total);
							$room_cnt = $faculty->getRoomCount($no);
							$deposit = (int)$faculty->feeDeposit * $room_cnt;
							$rental = (int)$faculty->feeRental * $room_cnt;
							$flag = $faculty->updateDepositFee($no, $deposit);
							$flag = $faculty->updateRentalFee($no, $rental);
							*/
							$faculty->calculateFee1($no, $rate, $arrival, $departure, $discount);
							if ($room_cnt > 0) $flag = $faculty->updateFacultyState($no, "AS");
							else $flag = $faculty->updateFacultyState($no, "IW");
							$faculty->approveFaculty($no, $ihouse_admin_info[grade], "Y");
					} else $mode = "error";
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
					//if ($detail == "DB" || $detail == "DD" || $detail == "LF" || $detail == "DQ" || $detail == "RR") $pay_type = "+";
					//else if ($detail != "ET") $pay_type = "-";
					if (!is_numeric($price)) $price = 0;
					if ($pay_type == "-") $price = "-" . $price;
					if ($pay_yy && $pay_mm && $pay_dd) {
						$pay_dt = $pay_yy . "-" . $pay_mm . "-" . $pay_dd;
						if ($price < 0) $pay_dt .= " 23:59:59";
					} else $pay_dt = "0000-00-00 00:00:00";
					$flag = $faculty->insertPayment($no, "E", $detail, $pay_dt, $price);
					if ($flag) {
						if ($detail == "DF") $state = "PD";
						else if ($detail == "RF") $state = "PR";
						else if ($detail == "DR") $state = "DR";
						$flag = $faculty->updateFacultyState($no, $state);
						$faculty->approveFaculty($no, $ihouse_admin_info[grade], "Y");
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
					//if ($detail == "DB" || $detail == "DD" || $detail == "LF" || $detail == "DQ" || $detail == "RR") $pay_type = "+";
					//else if ($detail != "ET") $pay_type = "-";
					if (!is_numeric($price)) $price = 0;
					if ($pay_type == "-") $price = "-" . $price;
					if ($pay_yy && $pay_mm && $pay_dd) {
						$pay_dt = $pay_yy . "-" . $pay_mm . "-" . $pay_dd;
						if ($price < 0) $pay_dt .= " 23:59:59";
					} else $pay_dt = "0000-00-00";
					$flag = $faculty->updatePayment($pay_no, $pay_dt, $price, $detail);
					if ($flag) {
						if ($detail == "DF") $state = "PD";
						else if ($detail == "RF") $state = "PR";
						else if ($detail == "DR") $state = "DR";
						$flag = $faculty->updateFacultyState($no, $state);
						$faculty->approveFaculty($no, $ihouse_admin_info[grade], "Y");
					} else $mode = "error";
					break;
				case "pay_del":
					$pay_no = $_POST["pay_no"];
					$arr_no = explode(",", $pay_no);
					for ($i = 0; $i < count($arr_no); $i++) {
						$flag = $faculty->deletePayment($arr_no[$i]);
						if (!$flag) {
							$mode = "error";
							break;
						}
					}
					if ($flag) $faculty->approveFaculty($no, $ihouse_admin_info[grade], "Y");
					break;
				case "fee":
					$faculty->getFacultyInfo($no);
					$rate = $faculty->facultyRate;
					$arrival = $faculty->facultyArrival;
					$departure = $faculty->facultyDeparture;
					$affiliate = $faculty->facultyAffiliate;
					$discount = $faculty->facultyDiscount;
					/*
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
					$faculty->calculateFee($rate, $affiliate, $count_dd, $count_mm, $count_total);
					$room_cnt = $faculty->getRoomCount($no);
					$deposit = (int)$faculty->feeDeposit * $room_cnt;
					$rental = (int)$faculty->feeRental * $room_cnt;
					$flag = $faculty->updateDepositFee($no, $deposit);
					$flag = $faculty->updateRentalFee($no, $rental);
					*/
					$faculty->calculateFee1($no, $rate, $arrival, $departure, $discount);
					$flag = $faculty->updateFacultyState($no, "AS");
					$faculty->approveFaculty($no, $ihouse_admin_info[grade], "Y");
					break;
				case "copy":
					$rate = $_POST["rate"];
					$flag = $faculty->copyFaculty($no, $rate);
					if (!$flag) $mode = "error";
					break;
				case "room";
					include_once("../../lib/class.rFastTemplate.php");
					$faculty->getFacultyInfo($no);
					$name = stripslashes($faculty->facultyTitle . ". " . $faculty->facultyLName . ", " . $faculty->facultyFName . " " . $faculty->facultyMName);
					$room = $faculty->getRoomValue($no);
					$period = $faculty->facultyArrival . " ~ " . $faculty->facultyDeparture;
					$deposit = $faculty->getDepositFee($no);
					$rate = number_format($faculty->getRentalFee($no)) . "won";
					$from = $ihouse_admin_info[name] . "<" . $ihouse_admin_info[email] . ">";
					$to = $faculty->facultyEmail;
					if ($faculty->facultyREmail) $to .= ";" . $faculty->facultyREmail;
					$subject = "[KU Residence Life] Room Assignment & Payment Information";
					$msg = "Dear $name,<br><br>\n";
					$msg .= "Thank you for your application.<br>\n";
					$msg .= "Your reservation is confirmed:<br><br>\n";
					$msg .= "<font style=\"text-decoration:underline;\">Application Number: <b>$no</b><br>\n";
					$msg .= "Room Number: <b>$room</b><br>\n";
					$msg .= "Room Phone Number: <b>$faculty->roomPhone</b><br>\n";
					$msg .= "Staying Period: <b>$period</b><br>\n";
					if ($deposit) $msg .= "Deposit(for long term residency of one month and longer only): <b>" . number_format($deposit) . "won</b><br>\n";
					$msg .= "Rate($period): <b>$rate</b></font><br><br>\n";
					$msg .= "The amount should be wired to our bank account before your arrival according to Korea University residence hall policy. Please note that Korea University Anam Residence Life Office does not accept cash or credit card.<br><br>\n";
					$msg .= "Our bank information is as follows:<br><br>\n";
					$msg .= "<font style=\"text-decoration:underline;\">BANK: Hana Bank, Godae Branch<br>\n";
					$msg .= "RECIPIENT: Korea University Anam Residence Life<br>\n";
					$msg .= "SWIFT CODE: HNBNKRSE<br>\n";
					$msg .= "ACCOUNT NO.: 391-910001-03204</font><br><br>\n";
					$msg .= "Please make sure to write your name in the reference field for Recipient.<br>\n";
					$msg .= "Upon checking in, there is a key deposit of 10,000won per key.<br><br>\n";
					if ($deposit) $msg .= "Please drop by the residence life office in CJ International House to sign a lease contract within 1 week after you check in.<br><br>\n";
					$msg .= "Thank you and we look forward to seeing you soon.<br><br>\n";
					$msg .= "Regards,<br><br>\n";
					$msg .= "Korea University<br>\n";
					$msg .= "Anam Residence Life<br>\n";
					$msg .= "International Residence<br>\n";
					$msg .= "Anam-Dong Seongbuk-Gu Seoul, 136-701 Korea<br>\n";
					$msg .= "Tel: 82-2-3290-1555<br>\n";
					$msg .= "Fax: 82-2-926-3464<br>\n";
					$msg .= "<a href=\"mailto:$cf_email_facility\">Email: $cf_email_facility</a>";
					$to = explode(";", $to);
					for ($i = 0; $i < count($to); $i++) {
						$flag = sendEmail($to[$i], $from, $subject, $msg);
						if (!$flag) {
							$mode = "error";
							break;
						} else $flag = $faculty->updateFacultyState($no, "CF");
					}
					break;
				case "invoice";
					// 전송 데이터 받기
					$dt = trim($_GET["dt"]);
					$invoice_no = trim($_GET["invoice_no"]);
					if (trim($dt) == "") $dt = trim($_POST["dt"]);
					if (trim($invoice_no) == "") $invoice_no = trim($_POST["invoice_no"]);
					// 페이지 설정
					include_once("../../lib/class.rFastTemplate.php");
					$tpl = new rFastTemplate("../../tpl/popup");
					$tpl->define(array(body => "invoice_f.html"));
					// 입금 내역 리스트
					$deposit_flag = false;
					$invoice_total = 0;
					//$faculty->getPaymentList($no, $dt);
					$faculty->getPaymentList1($no, $invoice_no);
					$invoice_count = count($faculty->payListNumber);
					for ($i = 0; $i < $invoice_count; $i++) {
						if ($invoice_count == 1 && $faculty->payListDetail[$i] == "DB") $deposit_flag = true;
						$invoice_total += (int)$faculty->payListPrice[$i];
						$tpl->assign(array(PAYMENT_DATE   => substr($faculty->payListDate[$i], 0, 10),
						                   PAYMENT_DETAIL => $faculty->getDetailValue($faculty->payListDetail[$i]),
						                   PAYMENT_AMOUNT => number_format($faculty->payListPrice[$i])));
						$tpl->parse(PAYMENT_ROWS, ".payment_row");
					}
					$faculty->getFacultyInfo($no);
					// 기간 설정
					if (trim($dt) != "") {
						$checkin = $dt . "-01";
						$checkout = $dt . "-" . date("t", mktime(0, 0, 0, substr($dt, 5, 2), 1, substr($dt, 0, 4)));
					} else {
						$checkin = $faculty->facultyArrival;
						$checkout = $faculty->facultyDeparture;
					}
					/*
					$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($faculty->facultyArrival, 5, 2) + 1, substr($faculty->facultyArrival, 8, 2), substr($faculty->facultyArrival, 0, 4)));
					if ($deposit_flag || $faculty->facultyDeparture < $temp_dt) {
						$checkin = $faculty->facultyArrival;
						$checkout = $faculty->facultyDeparture;
					} else {
						$checkin = substr($faculty->payListDate[0], 0, 10);
						if ($faculty->facultyArrival > $checkin) $checkin = substr($faculty->facultyArrival, 0, 10);
						$checkout = substr($faculty->payListDate[$invoice_count - 1], 0, 10);
						$temp_dt = substr($checkout, 0, 7);
						if (substr($faculty->facultyDeparture, 0, 7) == $temp_dt) $checkout = substr($faculty->facultyDeparture, 0, 10);
						else if (substr($faculty->facultyDeparture, 0, 7) != $temp_dt) $checkout = $temp_dt . "-" . date("t", mktime(0, 0, 0, substr($checkout, 5, 2), 1, substr($checkout, 0, 4)));
					}
					*/
					$sel_room = $faculty->getRoomValue($no);
					if ($dt == "") $inv_no = $no;
					else $inv_no = $no . "-" . substr($dt, 0, 4) . substr($dt, 5, 2);
					$assign_dt = $faculty->getRoomDate($no);
					if ($assign_dt == "" || substr($assign_dt, 0, 10) == "0000-00-00") $assign_dt = date("Y-m-d");
					$name = "";
					if ($faculty->facultyTitle) $name .= $faculty->facultyTitle . ". ";
					$name .= $faculty->facultyLName;
					if (trim($faculty->facultyFName)) $name .= ", " . $faculty->facultyFName . " " . $faculty->facultyMName;
					/*
					$checkin = $faculty->facultyArrival;
					$checkout = $faculty->facultyDeparture;
					$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($checkin, 5, 2) + 1, substr($checkin, 8, 2), substr($checkin, 0, 4)));
					if ($checkout < $temp_dt) {
					} else {
						$tpl->parse(METHOD_ROWS, ".method_row");
						if (substr($dt, 0, 7) != substr($checkin, 0, 7)) $checkin = $dt . "-01";
						if (substr($dt, 0, 7) != substr($checkout, 0, 7)) $checkout = $dt . "-" . date("t", mktime(0, 0, 0, substr($dt, 5, 2), 1, substr($dt, 0, 4)));
					}
					*/
					$tpl->assign(array(INVOICE_NUMBER   => $inv_no,
					                   INVOICE_DATE     => date("Y-m-d"),//substr($assign_dt, 0, 10),
					                   INVOICE_TO       => stripslashes($name),
					                   INVOICE_TOTAL    => number_format($invoice_total),
					                   INVOICE_PROPERTY => $faculty->getDormitoryCode($faculty->facultyDormitory),
					                   INVOICE_UNIT     => $sel_room,
					                   INVOICE_CHECKIN  => $checkin,
					                   INVOICE_CHECKOUT => $checkout));
					include("../common/variables_tpl.php");
					$tpl->parse(FINAL, "body");
					$msg = $tpl->GetTemplate(FINAL);
					unset($tpl);
					// 메일 보내기 설정
					$from = $ihouse_admin_info[name] . "<" . $ihouse_admin_info[email] . ">";
					$to = $faculty->facultyEmail;
					if ($faculty->facultyREmail) $to .= ";" . $faculty->facultyREmail;
					$subject = "[KU Residence Life] INVOICE";
					//$to = "gaultier74@naver.com";
					$to = explode(";", $to);
					for ($i = 0; $i < count($to); $i++) {
						$flag = sendEmail($to[$i], $from, $subject, $msg);
						if (!$flag) {
							$mode = "error";
							break;
						}
					}
					break;
				case "receipt";
					$dt = trim($_GET["dt"]);
					$receipt_no = trim($_GET["receipt_no"]);
					if (trim($dt) == "") $dt = trim($_POST["dt"]);
					if (trim($receipt_no) == "") $receipt_no = trim($_POST["receipt_no"]);
					include_once("../../lib/class.rFastTemplate.php");
					$tpl = new rFastTemplate("../../tpl/popup");
					$tpl->define(array(body => "receipt_f.html"));
					$tpl->define_dynamic(array(payment_row => "body",
					                           method_row  => "body"));
					$faculty->getFacultyInfo($no);
					$sel_room = $faculty->getRoomValue($no);
					$arrival = $faculty->facultyArrival;
					$departure = $faculty->facultyDeparture;
					$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($arrival, 5, 2) + 1, substr($arrival, 8, 2), substr($arrival, 0, 4)));
					if ($departure >= $temp_dt) $tpl->parse(METHOD_ROWS, ".method_row");
					$name = "";
					if ($faculty->facultyTitle) $name .= $faculty->facultyTitle . ". ";
					$name .= $faculty->facultyLName;
					if (trim($faculty->facultyFName)) $name .= ", " . $faculty->facultyFName . " " . $faculty->facultyMName;
					$receipt_total;
					$faculty->getPaymentList1($no, $receipt_no);
					for ($i = 0; $i < count($faculty->payListNumber); $i++) {
						if ((int)$faculty->payListPrice[$i] < 0) {
							$receipt_total += abs($faculty->payListPrice[$i]);
							$tpl->assign(array(PAYMENT_DATE   => substr($faculty->payListDate[$i], 0, 10),
							                   PAYMENT_DETAIL => $faculty->getDetailValue($faculty->payListDetail[$i]),
							                   PAYMENT_AMOUNT => number_format(abs($faculty->payListPrice[$i]))));
							$tpl->parse(PAYMENT_ROWS, ".payment_row");
						}
					}
					$assign_dt = $faculty->getRoomDate($no);
					if (substr($assign_dt, 0, 10) == "0000-00-00") $assign_dt = "2006-11-28";
					$checkin = $faculty->facultyArrival;
					$checkout = $faculty->facultyDeparture;
					if ($dt) {
						$temp_dt = date("Y-m-d", mktime(0, 0, 0, substr($checkin, 5, 2) + 1, substr($checkin, 8, 2), substr($checkin, 0, 4)));
						if ($checkout < $temp_dt) {
						} else {
							if (substr($dt, 0, 7) != substr($checkin, 0, 7)) $checkin = $dt . "-01";
							if (substr($dt, 0, 7) != substr($checkout, 0, 7)) $checkout = $dt . "-" . date("t", mktime(0, 0, 0, substr($dt, 5, 2), 1, substr($dt, 0, 4)));
						}
					}
					$tpl->assign(array(INVOICE_NUMBER   => $no,
					                   INVOICE_DATE     => date("Y-m-d"),//substr($assign_dt, 0, 10),
					                   INVOICE_TO       => stripslashes($name),
					                   INVOICE_TOTAL    => number_format($receipt_total),
					                   INVOICE_PROPERTY => $faculty->getDormitoryCode($faculty->facultyDormitory),
					                   INVOICE_UNIT     => $sel_room,
					                   INVOICE_CHECKIN  => $checkin,
					                   INVOICE_CHECKOUT => $checkout));
					include("../common/variables_tpl.php");
					$tpl->parse(FINAL, "body");
					$msg = $tpl->GetTemplate(FINAL);
					unset($tpl);
					$from = $ihouse_admin_info[name] . "<" . $ihouse_admin_info[email] . ">";
					$to = $faculty->facultyEmail;
					//$to = "shkim@intia.co.nz";
					if ($faculty->facultyREmail) $to .= ";" . $faculty->facultyREmail;
					$subject = "[KU Residence Life] RECEIPT";
					//$to = "gaultier74@naver.com";
					$to = explode(";", $to);
					for ($i = 0; $i < count($to); $i++) {
						$flag = sendEmail($to[$i], $from, $subject, $msg);
						if (!$flag) {
							$mode = "error";
							break;
						}
					}
					break;
				case "att_new";
					$attach_name = $HTTP_POST_FILES['attach']['name'];
					$attach_type = $HTTP_POST_FILES['attach']['type'];
					$attach_size = $HTTP_POST_FILES['attach']['size'];
					$attach_tmp = $HTTP_POST_FILES['attach']['tmp_name'];
					if ($attach_size <= $max_attach) {
						$flag = $faculty->insertAttachment($no, $attach_name, $attach_size, $attach_type);
						if ($flag) {
							if (is_uploaded_file($attach)) $flag = move_uploaded_file($attach_tmp, $attach_dir."/".$faculty->attachmentNumber);
							else $flag = false;
							if (!$flag) {
								$mode = "error";
								$faculty->deleteAttachment($faculty->attachmentNumber);
							}
						} else $mode = "error";
					} else $mode = "over";
					break;
				case "att_del";
					$arr_no = explode(",", $_POST["att_no"]);
					for ($i = 0; $i < count($arr_no); $i++) {
						$flag = $faculty->deleteAttachment($arr_no[$i]);
						if ($flag) {
							if (file_exists($attach_dir."/".$arr_no[$i])) unlink($attach_dir."/".$arr_no[$i]);
						} else {
							$mode = "error";
							break;
						}
					}
					break;
			}
			$faculty->closeDatabase();
			unset($faculty);
			if ($mode == "error") {
				echo "<script language=\"javascript\">";
				echo "alert(\"작업수행 중 오류가 발생하였습니다.\\n\\n나중에 다시 시도해 주세요.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "over") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"파일 용량은 " . round($max_attach / 1024 / 1024, 0) . "M이하여야 합니다.\\n\\n확인 후 다시 시도해 주세요.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "exist") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"객실 ". $room_new . "(은)는 이미 룸배정이 되어 있습니다.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "book") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"객실 ". $room_new . "(은)는 이미 예약이 완료된 상태입니다.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "less") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"International Faculty House는 장기 1개월 이상 입사자에게만 해당합니다.\");";
				echo "history.go(-1);";
				echo "</script>";
			} else if ($mode == "none") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"고려대학교에서 초청하는 교원 및 연구원에 한합니다.\");";
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
			} else if ($mode == "rm_new") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"룸배정을 성공적으로 추가하였습니다.\");";
				echo "document.location.replace(\"room_view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_term=$s_term&s_state=$s_state&s_grade=$s_grade&s_rate=$s_rate&s_room=$s_room&s_dorm=$s_dorm&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2\");";
				echo "</script>";
			} else if ($mode == "rm_del") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"룸배정을 성공적으로 삭제하였습니다.\");";
				echo "document.location.replace(\"room_view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_term=$s_term&s_state=$s_state&s_grade=$s_grade&s_rate=$s_rate&s_room=$s_room&s_dorm=$s_dorm&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2\");";
				echo "</script>";
			} else if ($mode == "fee") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"금액을 성공적으로 수정하였습니다.\");";
				echo "document.location.replace(\"room_view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_term=$s_term&s_state=$s_state&s_grade=$s_grade&s_rate=$s_rate&s_room=$s_room&s_dorm=$s_dorm&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2\");";
				echo "</script>";
			} else if ($mode == "copy") {
				echo "<script langauage=\"javascript\">";
				echo "alert(\"객실예약을 성공적으로 복사하였습니다.\");";
				echo "document.location.replace(\"room_list.php?page=$page&s_type=$s_type&s_text=$s_text&s_term=$s_term&s_state=$s_state&s_grade=$s_grade&s_rate=$s_rate&s_room=$s_room&s_dorm=$s_dorm&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2\");";
				echo "</script>";
			} else if ($mode == "edit" || $mode == "discount" || $mode == "pay_new" || $mode == "pay_edit" || $mode == "pay_del" || $mode == "att_new" || $mode == "att_del") header("Location: room_view.php?no=$no&page=$page&s_type=$s_type&s_text=$s_text&s_term=$s_term&s_state=$s_state&s_grade=$s_grade&s_rate=$s_rate&s_room=$s_room&s_dorm=$s_dorm&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2");
			else if ($mode == "del") header("Location: room_list.php?page=$page&s_type=$s_type&s_text=$s_text&s_term=$s_term&s_state=$s_state&s_grade=$s_grade&s_rate=$s_rate&s_room=$s_room&s_dorm=$s_dorm&s_year1=$s_year1&s_month1=$s_month1&s_day1=$s_day1&s_year2=$s_year2&s_month2=$s_month2&s_day2=$s_day2&sort1=$sort1&sort2=$sort2");
			else header("Location: room_list.php");
		}
	}
?>