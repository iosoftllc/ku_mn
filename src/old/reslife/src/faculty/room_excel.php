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
			$record = "������ȣ,��/�ܱ�,��������,������,����������,�̳���,�����ݹ̳���,���̳���,Ÿ��Ʋ,��������,�ѱۼ���,���������ȣ,���ָ���,���μ�,�����å,�����μ�,������å,";
			$record .= "����,�������,����,�̸���,��ȭ��ȣ,Contract Begins(Check-in Date),Contract Ends(Check-out Date),Billing From,Billing To,���ҹ��,";
			$record .= "��õ���̸�,��õ�κμ�,��õ����å,��õ���̸���,��õ����ȭ��ȣ,�Խ�����,�氳��,ȣ��,��ȭ��ȣ,IP�ּ�\n";
			$faculty->getFacultyExcel($s_dorm, $sdate, $edate, $s_type, $s_text, $s_term, $s_state, $s_grade, $s_rate, $s_room, $sort);
			for ($i = 0; $i < count($faculty->facListNumber); $i++) {
				if ($faculty->facListTerm[$i] == "���") {
					if (substr($cur_date, 0, 7) <= substr($faculty->facListArrival[$i], 0, 7)) $billing_from = $faculty->facListArrival[$i];
					else if (substr($cur_date, 0, 7) > substr($faculty->facListDeparture[$i], 0, 7)) $billing_from = substr($faculty->facListDeparture[$i], 0, 8) . "01";
					else $billing_from = substr($cur_date, 0, 8) . "01";
					if (substr($cur_date, 0, 7) >= substr($faculty->facListDeparture[$i], 0, 7)) $billing_to = $faculty->facListDeparture[$i];
					else if (substr($cur_date, 0, 7) <= substr($faculty->facListArrival[$i], 0, 7)) $billing_to = substr($faculty->facListArrival[$i], 0, 8) . $maxday;
					else $billing_to = substr($cur_date, 0, 8) . $maxday;
				} else if ($faculty->facListTerm[$i] == "�ܱ�") {
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
			$detail = "�� " . count($faculty->facListNumber) . "���� ���ǿ��� ���� �����ٿ�ε� - " . urldecode($purpose);
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