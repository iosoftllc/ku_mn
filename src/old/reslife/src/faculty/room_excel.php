<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 7) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/faculty_tpl.php");

			$cur_date = date("Y-m-d");
			$maxday = date('t', mktime(0, 0, 0, date("m"), 1, date("Y")));
			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$record = "지원번호,장/단기,지원상태,지원일,장기거주할인,미납액,보증금미납액,사비미납액,타이틀,영문성명,한글성명,고대직원번호,거주목적,고대부서,고대직책,본국부서,본국직책,";
			$record .= "국적,생년월일,국가,이메일,전화번호,Contract Begins(Check-in Date),Contract Ends(Check-out Date),Billing From,Billing To,지불방법,";
			$record .= "추천인이름,추천인부서,추천인직책,추천인이메일,추천인전화번호,입실형태,방개수,호실,전화번호,IP주소\n";
			$faculty->getFacultyExcel($s_dorm, $sdate, $edate, $s_type, $s_text, $s_term, $s_state, $s_grade, $s_rate, $s_room, $sort);
			for ($i = 0; $i < count($faculty->facListNumber); $i++) {
				if ($faculty->facListTerm[$i] == "장기") {
					if (substr($cur_date, 0, 7) <= substr($faculty->facListArrival[$i], 0, 7)) $billing_from = $faculty->facListArrival[$i];
					else if (substr($cur_date, 0, 7) > substr($faculty->facListDeparture[$i], 0, 7)) $billing_from = substr($faculty->facListDeparture[$i], 0, 8) . "01";
					else $billing_from = substr($cur_date, 0, 8) . "01";
					if (substr($cur_date, 0, 7) >= substr($faculty->facListDeparture[$i], 0, 7)) $billing_to = $faculty->facListDeparture[$i];
					else if (substr($cur_date, 0, 7) <= substr($faculty->facListArrival[$i], 0, 7)) $billing_to = substr($faculty->facListArrival[$i], 0, 8) . $maxday;
					else $billing_to = substr($cur_date, 0, 8) . $maxday;
				} else if ($faculty->facListTerm[$i] == "단기") {
					$billing_from = $faculty->facListArrival[$i];
					$billing_to = $faculty->facListDeparture[$i];
				} else {
					$billing_from = "";
					$billing_to = "";
				}
				$name = $faculty->facListLName[$i];
				if (trim($faculty->facListFName[$i])) $name .= ", " . $faculty->facListFName[$i] . " " . $faculty->facListMName[$i];
				$reference = $faculty->facListRLName[$i];
				if (trim($faculty->facListRFName[$i])) $reference .= ", " . $faculty->facListRFName[$i] . " " . $faculty->facListRMName[$i];
				$record .= "\"" . $faculty->facListNumber[$i] . "\",\"";
				$record .= $faculty->facListTerm[$i] . "\",\"";
				$record .= $faculty->getStateValue($faculty->facListState[$i]) . "\",\"";
				$record .= $faculty->facListDate[$i] . "\",\"";
				$record .= $faculty->facListDiscount[$i] . "\",\"";
				$record .= $faculty->getTotalPayment($faculty->facListNumber[$i]) . "\",\"";
				$record .= $faculty->getDepositPayment($faculty->facListNumber[$i]) . "\",\"";
				$record .= $faculty->getRentalPayment($faculty->facListNumber[$i]) . "\",\"";
				$record .= $faculty->facListTitle[$i] . "\",\"";
				$record .= $name . "\",\"";
				$record .= $faculty->facListKName[$i] . "\",\"";
				$record .= $faculty->facListEmployee[$i] . "\",\"";
				$record .= $faculty->facListPurpose[$i] . "\",\"";
				$record .= $faculty->facListKDepart[$i] . "\",\"";
				$record .= $faculty->facListKPosition[$i] . "\",\"";
				$record .= $faculty->facListHDepart[$i] . "\",\"";
				$record .= $faculty->facListHPosition[$i] . "\",\"";
				$record .= $faculty->facListNationality[$i] . "\",\"";
				$record .= $faculty->facListDOB[$i] . "\",\"";
				$record .= $faculty->facListCountry[$i] . "\",\"";
				$record .= $faculty->facListEmail[$i] . "\",\"";
				$record .= $faculty->facListPhone[$i] . "\",\"";
				$record .= $faculty->facListArrival[$i] . "\",\"";
				$record .= $faculty->facListDeparture[$i] . "\",\"";
				$record .= $billing_from . "\",\"";
				$record .= $billing_to . "\",\"";
				//$record .= $faculty->getAffiliateValue($faculty->facListAffiliate[$i]) . "\",\"";
				$record .= $faculty->getPaymentMethod($faculty->facListPMethod[$i]) . "\",\"";
				$record .= $reference . "\",\"";
				$record .= $faculty->facListRDepart[$i] . "\",\"";
				$record .= $faculty->facListRPosition[$i] . "\",\"";
				$record .= $faculty->facListREmail[$i] . "\",\"";
				$record .= $faculty->facListRPhone[$i] . "\",\"";
				$record .= $faculty->getDormitoryValue($faculty->facListDormitory[$i]) . " - " . $faculty->facListUnit[$i] . "\",\"";
				$record .= $faculty->facListNoRoom[$i] . "\",\"";
				//$record .= $faculty->getRoomValue($faculty->facListNumber[$i]) . "\",\"";
				//$record .= $faculty->roomListPhone[0] . "\",\"";
				//$record .= $faculty->roomListIP[0] . "\"\n";
				$record .= $faculty->getRoomValue($faculty->facListNumber[$i]) . "\",\"";
				$record .= $faculty->roomPhone . "\",\"";
				$record .= $faculty->roomIP . "\"\n";
			}
			$record = substr($record, 0, strlen($record) - 1);

			$purpose = $_GET["purpose"];
			if ($purpose == "") $purpose = $_POST["purpose"];
			$detail = "총 " . count($faculty->facListNumber) . "개의 객실예약 정보 엑셀다운로드 - " . urldecode($purpose);
			$faculty->insertHistoryWork("R", "X", $detail);

			$faculty->closeDatabase();
			unset($faculty);

			$csv_file = "../../../upload/temp.csv";
			$fp = fopen($csv_file, "w");
			fputs($fp, $record);
			fclose($fp);

			$date = date("Ymd");
			header("Content-type: application/octet-stream");
			header("Content-Length: " . filesize($csv_file));
			header("Content-Disposition: attachment; filename=faculty_$date.csv");
			header("Content-Transfer-Encoding: binary");
			header("Pragma: no-cache");
			header("Expires: 0");

			$fp = fopen($csv_file, "r"); 
			if(!fpassthru($fp)) fclose($fp);

			unlink($csv_file);
		}
	}
?>