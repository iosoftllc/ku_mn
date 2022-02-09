<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 7) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/faculty_tpl.php");
		
			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$record = "지원번호,성 명,날 짜,내 역,금 액\n";
			$faculty->getPaymentExcel($s_dorm, $sdate, $edate, $s_type, $s_text, $s_term, $s_state, $s_grade, $s_rate, $s_room, $sort);
			for ($i = 0; $i < count($faculty->payListNumber); $i++) {
				$record .= "\"" . $faculty->payListNumber[$i] . "\",\"";
				$record .= $faculty->payListName[$i] . "\",\"";
				$record .= $faculty->payListDate[$i] . "\",\"";
				$record .= $faculty->getDetailValue($faculty->payListDetail[$i]) . "\",\"";
				$record .= $faculty->payListPrice[$i] . "\"\n";
			}
			$record = substr($record, 0, strlen($record) - 1);

			$faculty->closeDatabase();
			unset($faculty);

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