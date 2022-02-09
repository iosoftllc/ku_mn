<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/apply_tpl.php");
		
			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$record = "지원번호,학 번,성 명,날 짜,내 역,금 액,지정된호실유형,지정된호실\n";
			$applicant->getExcelList1($sdate, $edate, $s_type, $s_text, $s_state, $s_kind, $s_current, $s_period, $sort);
			for ($i = 0; $i < count($applicant->payListNumber); $i++) {
				$applicant->getPreferenceList($applicant->payListNumber[$i], $applicant->payListPeriod[$i]);
				$sel_rate = "";
				if ($applicant->payListRate[$i] && $applicant->preRateCode[0] == $applicant->payListRate[$i]) $sel_rate = $applicant->getDormitoryValue($applicant->preRateDormitory[0]) . ": " . $applicant->preRateName[0] . " " . number_format($applicant->preRatePrice[0]) . "KRW";
				else if ($applicant->payListRate[$i] && $applicant->preRateCode[1] == $applicant->payListRate[$i]) $sel_rate = $applicant->getDormitoryValue($applicant->preRateDormitory[1]) . ": " . $applicant->preRateName[1] . " " . number_format($applicant->preRatePrice[1]) . "KRW";
				else if ($applicant->payListRate[$i] && $applicant->preRateCode[2] == $applicant->payListRate[$i]) $sel_rate = $applicant->getDormitoryValue($applicant->preRateDormitory[2]) . ": " . $applicant->preRateName[2] . " " . number_format($applicant->preRatePrice[2]) . "KRW";
				else if ($applicant->payListRate[$i] && $applicant->preRateCode[3] == $applicant->payListRate[$i]) $sel_rate = $applicant->getDormitoryValue($applicant->preRateDormitory[3]) . ": " . $applicant->preRateName[3] . " " . number_format($applicant->preRatePrice[3]) . "KRW";
				else if ($applicant->payListRate[$i] && $applicant->preRateCode[4] == $applicant->payListRate[$i]) $sel_rate = $applicant->getDormitoryValue($applicant->preRateDormitory[4]) . ": " . $applicant->preRateName[4] . " " . number_format($applicant->preRatePrice[4]) . "KRW";
				else if ($applicant->payListRate[$i] && $applicant->preRateCode[5] == $applicant->payListRate[$i]) $sel_rate = $applicant->getDormitoryValue($applicant->preRateDormitory[5]) . ": " . $applicant->preRateName[5] . " " . number_format($applicant->preRatePrice[5]) . "KRW";
				else if ($applicant->payListRate[$i] && $applicant->preRateCode[6] == $applicant->payListRate[$i]) $sel_rate = $applicant->getDormitoryValue($applicant->preRateDormitory[6]) . ": " . $applicant->preRateName[6] . " " . number_format($applicant->preRatePrice[6]) . "KRW";
				else if ($applicant->payListRate[$i] && $applicant->preRateCode[7] == $applicant->payListRate[$i]) $sel_rate = $applicant->getDormitoryValue($applicant->preRateDormitory[7]) . ": " . $applicant->preRateName[7] . " " . number_format($applicant->preRatePrice[7]) . "KRW";
		    $record .= "\"" . $applicant->payListNumber[$i] . "\",\"";
		    $record .= $applicant->payListStudent[$i] . "\",\"";
		    $record .= $applicant->payListName[$i] . "\",\"";
		    $record .= substr($applicant->payListDate[$i], 0, 10) . "\",\"";
		    $record .= $applicant->getDetailValue($applicant->payListDetail[$i]) . "\",\"";
		    $record .= $applicant->payListPrice[$i] . "\",\"";
		    $record .= $sel_rate . "\",\"";
		    $record .= $applicant->payListRoom[$i] . "\"\n";
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
  	  header("Content-Disposition: attachment; filename=payment_$date.csv");
  	  header("Content-Transfer-Encoding: binary");
  	  header("Pragma: no-cache");
  	  header("Expires: 0");
    
    	$fp = fopen($csv_file, "r"); 
    	if(!fpassthru($fp)) fclose($fp);
    
    	unlink($csv_file);
		}
	}
?>