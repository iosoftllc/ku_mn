<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 6 || (int)$ihouse_admin_info[grade] == 7 || (int)$ihouse_admin_info[grade] == 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/grad_application_tpl.php");

			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$record = "������ȣ,��������,�л�����,��翩��,������,�Խ���,�����,�����ݳ�����,�������,�̳���,����й�,��,�̸�,��Ī,��������,�ѱۼ���,����,�������,����,��,�а�,����,KGSP,�̸���,";
			$record .= "Ȩ�ּ�,��ȭ��ȣ,�ڵ�����ȣ,��޿���ó�̸�,��޿���ó����,��޿���ó��ȭ��ȣ,��޿���ó�ּ�,ü���Ⱓ,�����Ȼ������,������ȣ��,";
			$record .= "����ȭ��ȣ,��IP�ּ�,��Ÿ��1����,��Ÿ��2����,��Ÿ��3����,��Ÿ��4����,��Ÿ��5����,��Ÿ��6����,��Ÿ��7����,��Ÿ��8����,���ϴ�ȣ��,";
			$record .= "�����Ʈ�̸�,�����Ʈ�й�,�����Ʈ����,�����л�����,�ݿ��ڿ���,������ħ��,�����Ͼ,������ ������,���� ������,������������,Fee Transfer ��������,Fee Support ��������,TB Test ��������,�����ڳ�Ʈ\n";
			$application->getExcelList($sdate, $edate, $s_type, $s_text, $s_rate, $s_state, $s_grade, $s_kind, $s_current, $s_period, $sort);
			for ($i = 0; $i < count($application->listNumber); $i++) {
				$state = $application->getStateValue($application->listState[$i]);
				$gender = $application->getGenderValue($application->listGender[$i]);
				$paid_dt = $application->getDepositPaidDate($application->listNumber[$i]);
				if (trim($paid_dt) == "") $paid_dt = "";
				else $paid_dt = getFullDate($paid_dt);
				if ($application->listCheckinDate[$i] == "0000-00-00") $checkin = "";
				else $checkin = getFullDate($application->listCheckinDate[$i]);
				if ($application->listCheckoutDate[$i] == "0000-00-00") $checkout = "";
				else $checkout = getFullDate($application->listCheckoutDate[$i]);
				if ($application->listBirth[$i] == "0000-00-00") $dob = "";
				else $dob = getFullDate($application->listBirth[$i]);
				if ($application->listMateDOB[$i] == "0000-00-00") $mate_dob = "";
				else $mate_dob = getFullDate($application->listMateDOB[$i]);
				$period = $application->listPeriodName[$i];
				if ($application->listPeriodSDate[$i] == "0000-00-00" || $application->listPeriodEDate[$i] == "0000-00-00") $period .= "";
				else $period .= ": " . getFullDate($application->listPeriodSDate[$i]) . " - " . getFullDate($application->listPeriodEDate[$i]);
				$application->getPreferenceList($application->listNumber[$i], $application->listPeriodCode[$i]);
				if ($application->preRateCode[0]) $rate1 = $application->preRateName[0] . " " . number_format($application->preRatePrice[0]) . "KRW";
				else $rate1 = "";
				if ($application->preRateCode[1]) $rate2 = $application->preRateName[1] . " " . number_format($application->preRatePrice[1]) . "KRW";
				else $rate2 = "";
				if ($application->preRateCode[2]) $rate3 = $application->preRateName[2] . " " . number_format($application->preRatePrice[2]) . "KRW";
				else $rate3 = "";
				$sel_rate = "";
				if ($application->preRateCode[0] == $application->listRateCode[$i]) $sel_rate = $rate1;
				else if ($application->preRateCode[1] == $application->listRateCode[$i]) $sel_rate = $rate2;
				else if ($application->preRateCode[2] == $application->listRateCode[$i]) $sel_rate = $rate3;
				$photo_file = $pht_dir. "/". $application->listStudentNo[$i] . ".jpg";
				if (file_exists($photo_file)) $photo_flag = "Yes";
				else $photo_flag = "No";
				$fee_transfer_file = $fee_transfer_dir. "/". $application->listNumber[$i] . ".jpg";
				if (file_exists($fee_transfer_file)) $fee_transfer_flag = "Yes";
				else $fee_transfer_flag = "No";
				$fee_support_file = $fee_support_dir. "/". $application->listNumber[$i] . ".jpg";
				if (file_exists($fee_support_file)) $fee_support_flag = "Yes";
				else $fee_support_flag = "No";
				$tb_test_file = $tb_test_dir. "/". $application->listNumber[$i] . ".jpg";
				if (file_exists($tb_test_file)) $tb_test_flag = "Yes";
				else $tb_test_flag = "No";
				$nation = $application->listNation[$i];
				if (trim($application->listProvince[$i]) != "") $nation .= " - " . $application->listProvince[$i];
				$record .= "\"" . $application->listNumber[$i] . "\",\"";
				$record .= $state . "\",\"";
				$record .= $application->getKindValue($application->listKind[$i]) . "\",\"";
				$record .= $application->getCurrentValue($application->listCurrent[$i]) . "\",\"";
				$record .= getFullDate($application->listDate[$i]) . "\",\"";
				$record .= $checkin . "\",\"";
				$record .= $checkout . "\",\"";
				$record .= $paid_dt . "\",\"";
				$record .= $application->listAccount[$i] . "\",\"";
				$record .= $application->listPayment[$i] . "\",\"";
				$record .= $application->listStudentID[$i] . "\",\"";
				$record .= $application->listLastName[$i] . "\",\"";
				$record .= $application->listFirstName[$i] . " " . $application->listMiddleName[$i] . "\",\"";
				$record .= $application->listPreferName[$i] . "\",\"";
				$record .= $application->listLastName[$i] . ", " . $application->listFirstName[$i] . " " . $application->listMiddleName[$i] . "\",\"";
				$record .= $application->listKoreanName[$i] . "\",\"";
				$record .= $gender . "\",\"" . $dob . "\",\"";
				$record .= $nation . "\",\"";
				$record .= $application->listHomeUni[$i] . "\",\"";
				$record .= $application->listMajor[$i] . "\",\"";
				$record .= $application->getClassValue($application->listClass[$i]) . "\",\"";
				$record .= $application->getKGSPValue($application->listKGSP[$i]) . "\",\"";
				$record .= $application->listEmail[$i] . "\",\"";
				$record .= $application->listHomeAddress[$i] . "\",\"";
				$record .= $application->listPhone[$i] . "\",\"";
				$record .= $application->listMobile[$i] . "\",\"";
				$record .= $application->listCaseName[$i] . "\",\"";
				$record .= $application->listCaseRelate[$i] . "\",\"";
				$record .= $application->listCasePhone[$i] . "\",\"";
				$record .= $application->listCaseAddress[$i] . "\",\"";
				$record .= $period . "\",\"";
				$record .= $sel_rate . "\",\"";
				$record .= $application->listRoomCode[$i] . "\",\"";
				$record .= $application->listRoomPhone[$i] . "\",\"";
				$record .= $application->listRoomIP[$i] . "\",\"";
				$record .= $rate1 . "\",\"" . $rate2 . "\",\"" . $rate3 . "\",\"";
				$record .= $application->listRoomPrefer[$i] . "\",\"";
				$record .= $application->listMateName[$i] . "\",\"";
				$record .= $application->listMateID[$i] . "\",\"";
				$record .= $mate_dob . "\",\"";
				$record .= $application->getPreferenceValue($application->listMatchLocal[$i]) . "\",\"";
				$record .= $application->getPreferenceValue($application->listMatchNonSmoker[$i]) . "\",\"";
				$record .= $application->getPreferenceValue($application->listMatchBedEarly[$i]) . "\",\"";
				$record .= $application->getPreferenceValue($application->listMatchGetupEarly[$i]) . "\",\"";
				$record .= $application->getPreferenceValue($application->listMatchSilenceStudy[$i]) . "\",\"";
				$record .= $application->getPreferenceValue($application->listMatchDayStudy[$i]) . "\",\"";
				$record .= $photo_flag . "\",\"";
				$record .= $fee_transfer_flag . "\",\"";
				$record .= $fee_support_flag . "\",\"";
				$record .= $tb_test_flag . "\",\"";
				$record .= $application->listAdmin[$i] . "\"\n";
			}
			$record = substr($record, 0, strlen($record) - 1);

			$purpose = $_GET["purpose"];
			if ($purpose == "") $purpose = $_POST["purpose"];
			$detail = "�� " . count($application->listNumber) . "���� �¶������� ���� �����ٿ�ε� - " . urldecode($purpose);
			$application->insertHistoryWork("A", "X", $detail);

			$application->closeDatabase();
			unset($application);

			$csv_file = "../../../upload/temp.csv";
			$fp = fopen($csv_file, "w");
			fputs($fp, $record);
			fclose($fp);

			$date = date("Ymd");
			header("Content-type: application/octet-stream");
			header("Content-Length: " . filesize($csv_file));
			header("Content-Disposition: attachment; filename=application_$date.csv");
			header("Content-Transfer-Encoding: binary");
			header("Pragma: no-cache");
			header("Expires: 0");

			$fp = fopen($csv_file, "r"); 
			if(!fpassthru($fp)) fclose($fp);

			unlink($csv_file);
		}
	}
?>