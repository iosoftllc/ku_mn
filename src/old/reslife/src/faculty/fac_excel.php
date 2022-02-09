<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 7) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/facility_tpl.php");
		
			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$record = "지원번호,지원상태,이벤트명,신청자,거주여부,고대부서,고대직책,이메일,전화번호,이벤트일,이벤트시간,참석자수,조식신청,신청시설,입주자행사할인,종일대려할인,대여료,조식비,취소비,철회비,신청일,배정일,확인일,청구일,납부일,취소일,철회일\n";
			$facility->getFacilityList("", "", $s_room, $s_state, $s_grade, $sdate, $edate, $s_type, $s_text, $sort);
			for ($i = 0; $i < count($facility->facListNumber); $i++) {
				if ($facility->facListAssign[$i] == "0000-00-00") $assign_dt = "";
				else $assign_dt = $facility->facListAssign[$i];
				if ($facility->facListConfirm[$i] == "0000-00-00") $confirm_dt = "";
				else $confirm_dt = $facility->facListConfirm[$i];
				if ($facility->facListBilled[$i] == "0000-00-00") $billed_dt = "";
				else $billed_dt = $facility->facListBilled[$i];
				if ($facility->facListPaid[$i] == "0000-00-00") $paid_dt = "";
				else $paid_dt = $facility->facListPaid[$i];
				if ($facility->facListCancelDate[$i] == "0000-00-00") $cancel_dt = "";
				else $cancel_dt = $facility->facListCancelDate[$i];
				if ($facility->facListWaiveDate[$i] == "0000-00-00") $waive_dt = "";
				else $waive_dt = $facility->facListWaiveDate[$i];
				$temp_hr = explode("|", $facility->facListEventHour[$i]);
				if ($temp_hr[0] && $temp_hr[2]) $event_hr = $temp_hr[0] . "시" . $temp_hr[1] . "분 To " . $temp_hr[2] . "시" . $temp_hr[3] . "분";
				else $event_hr = "";
		    $record .= "\"" . $facility->facListNumber[$i] . "\",\"";
		    $record .= $facility->getStateValue($facility->facListState[$i]) . "\",\"";
		    $record .= $facility->facListEventName[$i] . "\",\"";
		    $record .= $facility->facListApplicant[$i] . "\",\"";
		    $record .= $facility->getResidentValue($facility->facListResident[$i]) . "\",\"";
		    $record .= $facility->facListDepartment[$i] . "\",\"";
		    $record .= $facility->facListPosition[$i] . "\",\"";
		    $record .= $facility->facListEmail[$i] . "\",\"";
		    $record .= $facility->facListPhone[$i] . "\",\"";
		    $record .= $facility->facListEventDate[$i] . "\",\"";
		    $record .= $event_hr . "\",\"";
		    $record .= $facility->facListAttendee[$i] . "\",\"";
		    $record .= $facility->getBreakfastValue($facility->facListBreakfast[$i]) . "\",\"";
		    $record .= $facility->getRequestValue($facility->facListRequest[$i]) . "\",\"";
		    $record .= $facility->facListDiscount1[$i] . "\",\"";
		    $record .= $facility->facListDiscount2[$i] . "\",\"";
		    $record .= $facility->facListFee[$i] . "\",\"";
		    $record .= $facility->facListMeal[$i] . "\",\"";
		    $record .= $facility->facListCancel[$i] . "\",\"";
		    $record .= $facility->facListWaive[$i] . "\",\"";
		    $record .= $facility->facListApply[$i] . "\",\"";
		    $record .= $assign_dt . "\",\"";
		    $record .= $confirm_dt . "\",\"";
		    $record .= $billed_dt . "\",\"";
		    $record .= $paid_dt . "\",\"";
		    $record .= $cancel_dt . "\",\"";
		    $record .= $waive_dt . "\"\n";
			}
			$record = substr($record, 0, strlen($record) - 1);

			$purpose = $_GET["purpose"];
			if ($purpose == "") $purpose = $_POST["purpose"];
			$detail = "총 " . count($facility->facListNumber) . "개의 시설예약 정보 엑셀다운로드 - " . urldecode($purpose);
			$facility->insertHistoryWork("F", "X", $detail);

			$facility->closeDatabase();
			unset($facility);

			$csv_file = "../../../upload/temp.csv";
	    $fp = fopen($csv_file, "w");
	    fputs($fp, $record);
	    fclose($fp);
    
  	  $date = date("Ymd");
  	  header("Content-type: application/octet-stream");
  	  header("Content-Length: " . filesize($csv_file));
  	  header("Content-Disposition: attachment; filename=facility_$date.csv");
  	  header("Content-Transfer-Encoding: binary");
  	  header("Pragma: no-cache");
  	  header("Expires: 0");
    
    	$fp = fopen($csv_file, "r"); 
    	if(!fpassthru($fp)) fclose($fp);
    
    	unlink($csv_file);
		}
	}
?>