<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/apply_tpl.php");
		
			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$record = "������ȣ,��������,��翩��,������,�������,�̳���,����й�,��,�̸�,��������,�ѱۼ���,����,�������,����,��,�а�,����,�̸���,";
			$record .= "Ȩ�ּ�,��ȭ��ȣ,�ڵ�����ȣ,��޿���ó�̸�,��޿���ó����,��޿���ó��ȭ��ȣ,��޿���ó�ּ�,ü���Ⱓ,������ȣ������,������ȣ��,";
			$record .= "����ȭ��ȣ,��IP�ּ�,��Ÿ��1����,��Ÿ��2����,��Ÿ��3����,��Ÿ��4����,��Ÿ��5����,��Ÿ��6����,��Ÿ��7����,��Ÿ��8����,���ϴ�ȣ��,";
			$record .= "�����Ʈ�̸�,�����Ʈ����,�ݿ��ڿ���,������ħ��,�����Ͼ,������ ������,���� ������\n";
			$applicant->getExcelList($sdate, $edate, $s_type, $s_text, $s_state, $s_kind, $s_current, $s_period, $sort);
			for ($i = 0; $i < count($applicant->listNumber); $i++) {
				$state = $applicant->getStateValue($applicant->listState[$i]);
				$gender = $applicant->getGenderValue($applicant->listGender[$i]);
				if ($applicant->listBirth[$i] == "0000-00-00") $dob = "";
				else $dob = getFullDate($applicant->listBirth[$i]);
				if ($applicant->listMateDOB[$i] == "0000-00-00") $mate_dob = "";
				else $mate_dob = getFullDate($applicant->listMateDOB[$i]);
				$period = $applicant->listPeriodName[$i];
				if ($applicant->listPeriodSDate[$i] == "0000-00-00" || $applicant->listPeriodEDate[$i] == "0000-00-00") $period .= "";
				else $period .= ": " . getFullDate($applicant->listPeriodSDate[$i]) . " - " . getFullDate($applicant->listPeriodEDate[$i]);
				$applicant->getPreferenceList($applicant->listNumber[$i], $applicant->listPeriodCode[$i]);
				if ($applicant->preRateCode[0]) $rate1 = $applicant->getDormitoryValue($applicant->preRateDormitory[0]) . ": " . $applicant->preRateName[0] . " " . number_format($applicant->preRatePrice[0]) . "KRW";
				else $rate1 = "";
				if ($applicant->preRateCode[1]) $rate2 = $applicant->getDormitoryValue($applicant->preRateDormitory[1]) . ": " . $applicant->preRateName[1] . " " . number_format($applicant->preRatePrice[1]) . "KRW";
				else $rate2 = "";
				if ($applicant->preRateCode[2]) $rate3 = $applicant->getDormitoryValue($applicant->preRateDormitory[2]) . ": " . $applicant->preRateName[2] . " " . number_format($applicant->preRatePrice[2]) . "KRW";
				else $rate3 = "";
				if ($applicant->preRateCode[3]) $rate4 = $applicant->getDormitoryValue($applicant->preRateDormitory[3]) . ": " . $applicant->preRateName[3] . " " . number_format($applicant->preRatePrice[3]) . "KRW";
				else $rate4 = "";
				if ($applicant->preRateCode[4]) $rate5 = $applicant->getDormitoryValue($applicant->preRateDormitory[4]) . ": " . $applicant->preRateName[4] . " " . number_format($applicant->preRatePrice[4]) . "KRW";
				else $rate5 = "";
				if ($applicant->preRateCode[5]) $rate6 = $applicant->getDormitoryValue($applicant->preRateDormitory[5]) . ": " . $applicant->preRateName[5] . " " . number_format($applicant->preRatePrice[5]) . "KRW";
				else $rate6 = "";
				if ($applicant->preRateCode[6]) $rate7 = $applicant->getDormitoryValue($applicant->preRateDormitory[6]) . ": " . $applicant->preRateName[6] . " " . number_format($applicant->preRatePrice[6]) . "KRW";
				else $rate7 = "";
				if ($applicant->preRateCode[7]) $rate8 = $applicant->getDormitoryValue($applicant->preRateDormitory[7]) . ": " . $applicant->preRateName[7] . " " . number_format($applicant->preRatePrice[7]) . "KRW";
				else $rate8 = "";
				$sel_rate = "";
				if ($applicant->preRateCode[0] == $applicant->listRateCode[$i]) $sel_rate = $rate1;
				else if ($applicant->preRateCode[1] == $applicant->listRateCode[$i]) $sel_rate = $rate2;
				else if ($applicant->preRateCode[2] == $applicant->listRateCode[$i]) $sel_rate = $rate3;
				else if ($applicant->preRateCode[3] == $applicant->listRateCode[$i]) $sel_rate = $rate4;
				else if ($applicant->preRateCode[4] == $applicant->listRateCode[$i]) $sel_rate = $rate5;
				else if ($applicant->preRateCode[5] == $applicant->listRateCode[$i]) $sel_rate = $rate6;
				else if ($applicant->preRateCode[6] == $applicant->listRateCode[$i]) $sel_rate = $rate7;
				else if ($applicant->preRateCode[7] == $applicant->listRateCode[$i]) $sel_rate = $rate8;
		    $record .= "\"" . $applicant->listNumber[$i] . "\",\"";
		    $record .= $state . "\",\"";
		    $record .= $applicant->getResidentValue($applicant->listCurrent[$i]) . "\",\"";
		    $record .= getFullDate($applicant->listDate[$i]) . "\",\"";
		    $record .= $applicant->listAccount[$i] . "\",\"";
		    $record .= $applicant->listPayment[$i] . "\",\"";
		    $record .= $applicant->listStudentID[$i] . "\",\"";
		    $record .= $applicant->listLastName[$i] . "\",\"";
		    $record .= $applicant->listFirstName[$i] . "\",\"";
		    $record .= $applicant->listLastName[$i] . ", " . $applicant->listFirstName[$i] . "\",\"";
		    $record .= $applicant->listKoreanName[$i] . "\",\"";
		    $record .= $gender . "\",\"" . $dob . "\",\"";
		    $record .= $applicant->listNation[$i] . "\",\"";
		    $record .= $applicant->listHomeUni[$i] . "\",\"";
		    $record .= $applicant->listMajor[$i] . "\",\"";
		    $record .= $applicant->getClassValue($applicant->listClass[$i]) . "\",\"";
		    $record .= $applicant->listEmail[$i] . "\",\"";
		    $record .= $applicant->listHomeAddress[$i] . "\",\"";
		    $record .= $applicant->listPhone[$i] . "\",\"";
		    $record .= $applicant->listMobile[$i] . "\",\"";
		    $record .= $applicant->listCaseName[$i] . "\",\"";
		    $record .= $applicant->listCaseRelate[$i] . "\",\"";
		    $record .= $applicant->listCasePhone[$i] . "\",\"";
		    $record .= $applicant->listCaseAddress[$i] . "\",\"";
		    $record .= $period . "\",\"";
		    $record .= $sel_rate . "\",\"";
		    $record .= $applicant->listRoomCode[$i] . "\",\"";
		    $record .= $applicant->listRoomPhone[$i] . "\",\"";
		    $record .= $applicant->listRoomIP[$i] . "\",\"";
		    $record .= $rate1 . "\",\"" . $rate2 . "\",\"" . $rate3 . "\",\"" . $rate4 . "\",\"" . $rate5 . "\",\"" . $rate6 . "\",\"" . $rate7 . "\",\"" . $rate8 . "\",\"";
		    $record .= $applicant->listRoomPrefer[$i] . "\",\"";
		    $record .= $applicant->listMateName[$i] . "\",\"";
		    $record .= $mate_dob . "\",\"";
		    $record .= $applicant->getPreferenceValue($applicant->listMatchNonSmoker[$i]) . "\",\"";
		    $record .= $applicant->getPreferenceValue($applicant->listMatchBedEarly[$i]) . "\",\"";
		    $record .= $applicant->getPreferenceValue($applicant->listMatchGetupEarly[$i]) . "\",\"";
		    $record .= $applicant->getPreferenceValue($applicant->listMatchSilenceStudy[$i]) . "\",\"";
		    $record .= $applicant->getPreferenceValue($applicant->listMatchDayStudy[$i]) . "\"\n";
			}
			$record = substr($record, 0, strlen($record) - 1);

			$applicant->closeDatabase();
			unset($applicant);

			$csv_file = "../../../upload/temp.csv";
	    $fp = fopen($csv_file, "w");
	    fputs($fp, $record);
	    fclose($fp);
    
  	  $date = date("Ymd");
  	  header("Content-type: application/octet-stream");
  	  header("Content-Length: " . filesize($csv_file));
  	  header("Content-Disposition: attachment; filename=applicant_$date.csv");
  	  header("Content-Transfer-Encoding: binary");
  	  header("Pragma: no-cache");
  	  header("Expires: 0");
    
    	$fp = fopen($csv_file, "r"); 
    	if(!fpassthru($fp)) fclose($fp);
    
    	unlink($csv_file);
		}
	}
?>