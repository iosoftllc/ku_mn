<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/apply_tpl.php");
    	
			$current = "N";
    	
			include_once("../common/header_tpl.php");
    	
			$tpl->define_dynamic(array(year_row   => "body",
			                           month_row  => "body",
			                           period_row => "body",
			                           ihouse_row => "body",
			                           anam2_row  => "body",
			                           rate1_row  => "body",
			                           rate2_row  => "body"));
    	
			for ($i = 1950; $i <= date("Y"); $i++) {
				$tpl->assign(YEAR_VALUE, $i);
				$tpl->parse(YEAR_ROWS, ".year_row");
			}
			for ($i = 1; $i <= 12; $i++) {
				$temp = $i;
				if ($temp < 10) $temp = "0" . $temp;
				$tpl->assign(MONTH_VALUE, $temp);
				$tpl->parse(MONTH_ROWS, ".month_row");
			}
    	
			$applicant->getPeriodList($kind);
			for ($i = 0; $i < count($applicant->periodCode); $i++) {
				$temp = "";
				if ($applicant->periodCode[$i]) $temp = $applicant->periodName[$i] . ": " . getEnglishDate($applicant->periodSDate[$i]) . " - " . getEnglishDate($applicant->periodEDate[$i]);
				$tpl->assign(array(PEDIOD_VALUE => $applicant->periodCode[$i],
				                   PEDIOD_NAME  => stripslashes($temp)));
				$tpl->parse(PERIOD_ROWS, ".period_row");
			}
    	
			$state = "IW";
			$admin = "";
			$student = "";
			$fname = "";
			$mname = "";
			$lname = "";
			$name_kr = "";
			$gender = "M";
			$dob = "";
			$nation = "";
			$email = "";
			$phone = "";
			$cell = "";
			$major = "";
			$sclass = "P";
			$home_uni = "";
			$home_addr = "";
			$mate_nm = "";
			$mate_dob = "";
			$room_prefer = "";
			$match_pre1 = "M";
			$match_pre2 = "M";
			$match_pre3 = "M";
			$match_pre4 = "M";
			$match_pre5 = "M";
			$case_nm = "";
			$case_rel = "";
			$case_ph = "";
			$case_addr = "";
			$room = "";
			$rate1 = "";
			$rate2 = "";
			$rate3 = "";
			$rate4 = "";
			$rate5 = "";
			$rate6 = "";
			$rate7 = "";
			$rate8 = "";
			$sel_rate = "";
			$period = "";
			$settle1 = "N";
			$settle2 = "N";
			$settle3 = "N";
			$settle4 = "N";
			$account = "";
			$photo = "";
			if ($mode == "edit") {
				$page_name .= " 수정";
				$applicant->getApplicantInfo($no);
				$state = $applicant->applyState;
				$admin = stripslashes($applicant->applyAdmin);
				$student = $applicant->personStudentID;
				$fname = stripslashes($applicant->personFirstName);
				$mname = stripslashes($applicant->personMiddleName);
				$lname = stripslashes($applicant->personLastName);
				$name_kr = stripslashes($applicant->personKoreanName);
				$gender = $applicant->personGender;
				$dob = explode("-", $applicant->personBirthDate);
				$nation = stripslashes($applicant->personNationality);
				$email = $applicant->personEmail;
				$phone = $applicant->personPhone;
				$cell = $applicant->personCell;
				$major = stripslashes($applicant->personMajor);
				$sclass = $applicant->personClass;
				$home_uni = stripslashes($applicant->personHomeUni);
				$home_addr = stripslashes($applicant->personHomeAddress);
				$mate_nm = stripslashes($applicant->mateName);
				$mate_dob = explode("-", $applicant->mateBirthDate);
				$room_prefer = $applicant->roomPrefer;
				$match_pre1 = $applicant->matchNonSmoker;
				$match_pre2 = $applicant->matchBedEarly;
				$match_pre3 = $applicant->matchGetupEarly;
				$match_pre4 = $applicant->matchSilenceStudy;
				$match_pre5 = $applicant->matchDayStudy;
				$case_nm = stripslashes($applicant->contactName);
				$case_rel = stripslashes($applicant->contactRelation);
				$case_ph = $applicant->contactPhone;
				$case_addr = stripslashes($applicant->contactAddress);
				$current = $applicant->currentResident;
				$room = $applicant->linkRoomCode;
				$period = $applicant->linkPeriodCode;
				$settle1 = $applicant->settleFlag1;
				$settle2 = $applicant->settleFlag2;
				$settle3 = $applicant->settleFlag3;
				$settle4 = $applicant->settleFlag4;
				$applicant->getPreferenceList($no, $applicant->linkPeriodCode);
				$rate1 = $applicant->preRateCode[0];
				$rate2 = $applicant->preRateCode[1];
				$rate3 = $applicant->preRateCode[2];
				$rate4 = $applicant->preRateCode[3];
				$rate5 = $applicant->preRateCode[4];
				$rate6 = $applicant->preRateCode[5];
				$rate7 = $applicant->preRateCode[6];
				$rate8 = $applicant->preRateCode[7];
				if (trim($applicant->preRateCode[0]) && $applicant->preRateCode[0] == $applicant->linkRateCode) $sel_rate = "1";
				else if (trim($applicant->preRateCode[1]) && $applicant->preRateCode[1] == $applicant->linkRateCode) $sel_rate = "2";
				else if (trim($applicant->preRateCode[2]) && $applicant->preRateCode[2] == $applicant->linkRateCode) $sel_rate = "3";
				else if (trim($applicant->preRateCode[3]) && $applicant->preRateCode[3] == $applicant->linkRateCode) $sel_rate = "4";
				else if (trim($applicant->preRateCode[4]) && $applicant->preRateCode[4] == $applicant->linkRateCode) $sel_rate = "5";
				else if (trim($applicant->preRateCode[5]) && $applicant->preRateCode[5] == $applicant->linkRateCode) $sel_rate = "6";
				else if (trim($applicant->preRateCode[6]) && $applicant->preRateCode[6] == $applicant->linkRateCode) $sel_rate = "7";
				else if (trim($applicant->preRateCode[7]) && $applicant->preRateCode[7] == $applicant->linkRateCode) $sel_rate = "8";
				$account = $applicant->applyAccount;
				$photo = getUploadImage("$pht_dir/$no.jpg");
			} else $page_name .= " 추가";
    	
			$tpl->assign(array(MODE              => $mode,
			                   SEL_PAGE          => $page,
			                   SEARCH_TYPE       => $s_type,
			                   SEARCH_TEXT       => $s_text,
			                   SEARCH_KIND       => $s_kind,
			                   SEARCH_STATE      => $s_state,
			                   SEARCH_CURRENT    => $s_current,
			                   SEARCH_PERIOD     => $s_period,
			                   SORT1_VALUE       => $sort1,
			                   SORT2_VALUE       => $sort2,
			                   APPLY_NUMBER      => $no,
			                   APPLY_STATE       => $state,
			                   APPLY_ADMIN       => $admin,
			                   APPLY_ROOMMATES   => $applicant->applyRoommate,
			                   APPLY_STUDENT     => $student,
			                   APPLY_FNAME       => $fname,
			                   APPLY_MNAME       => $mname,
			                   APPLY_LNAME       => $lname,
			                   APPLY_KRNAME      => $name_kr,
			                   APPLY_GENDER      => $gender,
			                   APPLY_DOB_YY      => $dob[0],
			                   APPLY_DOB_MM      => $dob[1],
			                   APPLY_DOB_DD      => $dob[2],
			                   APPLY_NATION      => $nation,
			                   APPLY_EMAIL       => $email,
			                   APPLY_PHONE       => $phone,
			                   APPLY_CELL        => $cell,
			                   APPLY_MAJOR       => $major,
			                   APPLY_CLASS       => $sclass,
			                   APPLY_HOME_UNI    => $home_uni,
			                   APPLY_HOME_ADDR   => $home_addr,
			                   APPLY_MATE_NAME   => $mate_nm,
			                   APPLY_MATE_DOB_YY => $mate_dob[0],
			                   APPLY_MATE_DOB_MM => $mate_dob[1],
			                   APPLY_MATE_DOB_DD => $mate_dob[2],
			                   APPLY_CURRENT     => $current,
			                   APPLY_PREFER      => $room_prefer,
			                   APPLY_PREFERENCE1 => $match_pre1,
			                   APPLY_PREFERENCE2 => $match_pre2,
			                   APPLY_PREFERENCE3 => $match_pre3,
			                   APPLY_PREFERENCE4 => $match_pre4,
			                   APPLY_PREFERENCE5 => $match_pre5,
			                   APPLY_CASE_NAME   => $case_nm,
			                   APPLY_CASE_RELATE => $case_rel,
			                   APPLY_CASE_PHONE  => $case_ph,
			                   APPLY_CASE_ADDR   => $case_addr,
			                   APPLY_ROOM        => $room,
			                   APPLY_RATE1       => $rate1,
			                   APPLY_RATE2       => $rate2,
			                   APPLY_RATE3       => $rate3,
			                   APPLY_RATE4       => $rate4,
			                   APPLY_RATE5       => $rate5,
			                   APPLY_RATE6       => $rate6,
			                   APPLY_RATE7       => $rate7,
			                   APPLY_RATE8       => $rate8,
			                   APPLY_SEL_RATE    => $sel_rate,
			                   APPLY_PERIOD      => $period,
			                   APPLY_SETTLE1     => $settle1,
			                   APPLY_SETTLE2     => $settle2,
			                   APPLY_SETTLE3     => $settle3,
			                   APPLY_SETTLE4     => $settle4,
			                   APPLY_ACCOUNT     => $account,
			                   APPLY_PHOTO       => $photo));

			$applicant->closeDatabase();
			unset($applicant);
    	
			include_once("../common/footer_tpl.php");
		}
	}
?>