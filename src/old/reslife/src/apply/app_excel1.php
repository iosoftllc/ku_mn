<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/application_tpl.php");
		
			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$record = "지원번호,가상계좌번호,학 번,성 명,날 짜,내 역,금 액,지정된사실유형,지정된호실\n";
			$application->getExcelList1($sdate, $edate, $s_type, $s_text, $s_rate, $s_state, $s_grade, $s_kind, $s_current, $s_period, $sort);
			for ($i = 0; $i < count($application->payListNumber); $i++) {
				$application->getPreferenceList($application->payListNumber[$i], $application->payListPeriod[$i]);
				$sel_rate = "";
				if ($application->payListRate[$i] && $application->preRateCode[0] == $application->payListRate[$i]) $sel_rate = $application->getDormitoryValue($application->preRateDormitory[0], $application->preRateCode[0]) . ": " . $application->preRateName[0] . " " . number_format($application->preRatePrice[0]) . "KRW";
				else if ($application->payListRate[$i] && $application->preRateCode[1] == $application->payListRate[$i]) $sel_rate = $application->getDormitoryValue($application->preRateDormitory[1], $application->preRateCode[1]) . ": " . $application->preRateName[1] . " " . number_format($application->preRatePrice[1]) . "KRW";
				else if ($application->payListRate[$i] && $application->preRateCode[2] == $application->payListRate[$i]) $sel_rate = $application->getDormitoryValue($application->preRateDormitory[2], $application->preRateCode[2]) . ": " . $application->preRateName[2] . " " . number_format($application->preRatePrice[2]) . "KRW";
				else if ($application->payListRate[$i] && $application->preRateCode[3] == $application->payListRate[$i]) $sel_rate = $application->getDormitoryValue($application->preRateDormitory[3], $application->preRateCode[3]) . ": " . $application->preRateName[3] . " " . number_format($application->preRatePrice[3]) . "KRW";
				else if ($application->payListRate[$i] && $application->preRateCode[4] == $application->payListRate[$i]) $sel_rate = $application->getDormitoryValue($application->preRateDormitory[4], $application->preRateCode[4]) . ": " . $application->preRateName[4] . " " . number_format($application->preRatePrice[4]) . "KRW";
				else if ($application->payListRate[$i] && $application->preRateCode[5] == $application->payListRate[$i]) $sel_rate = $application->getDormitoryValue($application->preRateDormitory[5], $application->preRateCode[5]) . ": " . $application->preRateName[5] . " " . number_format($application->preRatePrice[5]) . "KRW";
				else if ($application->payListRate[$i] && $application->preRateCode[6] == $application->payListRate[$i]) $sel_rate = $application->getDormitoryValue($application->preRateDormitory[6], $application->preRateCode[6]) . ": " . $application->preRateName[6] . " " . number_format($application->preRatePrice[6]) . "KRW";
				else if ($application->payListRate[$i] && $application->preRateCode[7] == $application->payListRate[$i]) $sel_rate = $application->getDormitoryValue($application->preRateDormitory[7], $application->preRateCode[7]) . ": " . $application->preRateName[7] . " " . number_format($application->preRatePrice[7]) . "KRW";
				$record .= "\"" . $application->payListNumber[$i] . "\",\"";
				$record .= $application->listAccount[$i] . "\",\"";
				$record .= $application->payListStudent[$i] . "\",\"";
				$record .= $application->payListName[$i] . "\",\"";
				$record .= substr($application->payListDate[$i], 0, 10) . "\",\"";
				$record .= $application->getDetailValue($application->payListDetail[$i]) . "\",\"";
				$record .= $application->payListPrice[$i] . "\",\"";
				$record .= $sel_rate . "\",\"";
				$record .= $application->payListRoom[$i] . "\"\n";
			}
			$record = substr($record, 0, strlen($record) - 1);

			$application->closeDatabase();
			unset($application);

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