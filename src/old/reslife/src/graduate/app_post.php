<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 6 || (int)$ihouse_admin_info[grade] == 7 || (int)$ihouse_admin_info[grade] == 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/grad_application_tpl.php");
    	
			include_once("../common/header_tpl.php");
    	
			$tpl->define_dynamic(array(year_row   => "body",
			                           month_row  => "body",
			                           period_row => "body"));
    	
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
    	
			$application->getPeriodList();
			for ($i = 0; $i < count($application->periodCode); $i++) {
				$tpl->assign(array(PEDIOD_VALUE => $application->periodCode[$i],
				                   PEDIOD_NAME  => stripslashes($application->periodName[$i])));
				$tpl->parse(PERIOD_ROWS, ".period_row");
			}
    	
			$student = "";
			$current = "";
			$kind = "";
			$name = "";
			$name_kr = "";
			$gender = "";
			$dob = "";
			$nation = "";
			$province = "";
			$kgsp = "";
			$home_uni = "";
			$major = "";
			$sclass = "";
			$home_addr = "";
			$email = "";
			$phone = "";
			$cell = "";
			$photo = "";
			$case_nm = "";
			$case_rel = "";
			$case_ph = "";
			$case_addr = "";
			$state = "IW";
			$admin = "";
			$mate_nm = "";
			$mate_id = "";
			$mate_dob = "";
			$room_prefer = "";
			$match_pre1 = "M";
			$match_pre2 = "M";
			$match_pre3 = "M";
			$match_pre4 = "M";
			$match_pre5 = "M";
			$match_pre6 = "M";
			$room = "";
			$rate1 = "";
			$rate2 = "";
			$rate3 = "";
			$sel_rate = "";
			$checkin = "";
			$checkout = "";
			$period = "";
			$settle1 = "N";
			$settle2 = "N";
			$settle3 = "N";
			$settle4 = "N";
			$account = "";
			$fee_transfer = "";
			$fee_support = "";
			$tb_test = "";
			if ($mode == "edit") {
				$page_name .= " 수정";
				$application->getApplicationInfo($no);
				$student = $application->personStudentID;
				$current = $application->currentResident;
				$kind = $application->applyKind;
				$name = stripslashes($application->personLastName . ", " . $application->personFirstName . " " . $application->personMiddleName);
				$name_kr = stripslashes($application->personKoreanName);
				$gender = $application->personGender;
				$dob = $application->personBirthDate;
				$nation = stripslashes($application->personNationality);
				$province = stripslashes($application->personProvince);
				$kgsp = $application->getKGSPValue($application->personKGSP);
				$home_uni = stripslashes($application->personHomeUni);
				$major = stripslashes($application->personMajor);
				$sclass = $application->personClass;
				$home_addr = stripslashes($application->personHomeAddress);
				$email = $application->personEmail;
				$phone = $application->personPhone;
				$cell = $application->personCell;
				$photo = getUploadImage($pht_dir."/".$application->personStudentNo.".jpg");
				$case_nm = stripslashes($application->contactName);
				$case_rel = stripslashes($application->contactRelation);
				$case_ph = $application->contactPhone;
				$case_addr = stripslashes($application->contactAddress);
				$state = $application->applyState;
				$admin = stripslashes($application->applyAdmin);
				$mate_nm = stripslashes($application->mateName);
				$mate_id = stripslashes($application->mateID);
				$mate_dob = explode("-", $application->mateBirthDate);
				$room_prefer = $application->roomPrefer;
				$match_pre1 = $application->matchNonSmoker;
				$match_pre2 = $application->matchBedEarly;
				$match_pre3 = $application->matchGetupEarly;
				$match_pre4 = $application->matchSilenceStudy;
				$match_pre5 = $application->matchDayStudy;
				$match_pre6 = $application->matchLocal;
				$room = $application->linkRoomCode;
				$checkin = $application->applyCheckinDate;
				$checkout = $application->applyCheckoutDate;
				$period = $application->linkPeriodCode;
				$settle1 = $application->settleFlag1;
				$settle2 = $application->settleFlag2;
				$settle3 = $application->settleFlag3;
				$settle4 = $application->settleFlag4;
				$application->getPreferenceList($no, $application->linkPeriodCode);
				$rate1 = $application->preRateCode[0];
				$rate2 = $application->preRateCode[1];
				$rate3 = $application->preRateCode[2];
				if (trim($application->preRateCode[0]) && $application->preRateCode[0] == $application->linkRateCode) $sel_rate = "1";
				else if (trim($application->preRateCode[1]) && $application->preRateCode[1] == $application->linkRateCode) $sel_rate = "2";
				else if (trim($application->preRateCode[2]) && $application->preRateCode[2] == $application->linkRateCode) $sel_rate = "3";
				$account = $application->applyAccount;
				$fee_transfer = getUploadImage("$fee_transfer_dir/$no.jpg");
				$fee_support = getUploadImage("$fee_support_dir/$no.jpg");
				$tb_test = getUploadImage("$tb_test_dir/$no.jpg");
			} else $page_name .= " 추가";
    	
			$tpl->assign(array(MODE               => $mode,
			                   SEL_PAGE           => $page,
			                   SEARCH_TYPE        => $s_type,
			                   SEARCH_TEXT        => $s_text,
			                   SEARCH_KIND        => $s_kind,
			                   SEARCH_RATE        => $s_rate,
			                   SEARCH_STATE       => $s_state,
			                   SEARCH_GRADE       => $s_grade,
			                   SEARCH_CURRENT     => $s_current,
			                   SEARCH_PERIOD      => $s_period,
			                   SEARCH_YEAR1       => $s_year1,
			                   SEARCH_MONTH1      => $s_month1,
			                   SEARCH_DAY1        => $s_day1,
			                   SEARCH_YEAR2       => $s_year2,
			                   SEARCH_MONTH2      => $s_month2,
			                   SEARCH_DAY2        => $s_day2,
			                   SORT1_VALUE        => $sort1,
			                   SORT2_VALUE        => $sort2,
			                   APPLY_NUMBER       => $no,
			                   APPLY_CURRENT      => $current,
			                   APPLY_STATE        => $state,
			                   APPLY_ACCOUNT      => $account,
			                   APPLY_ROOMMATES    => $application->applyRoommate,
			                   APPLY_ROOM         => $room,
			                   APPLY_SETTLE1      => $settle1,
			                   APPLY_SETTLE2      => $settle2,
			                   APPLY_SETTLE3      => $settle3,
			                   APPLY_SETTLE4      => $settle4,
			                   APPLY_ADMIN        => $admin,
			                   APPLY_STUDENT      => $student,
			                   APPLY_CURRENT1     => $application->getCurrentValue($current),
			                   APPLY_KIND         => $application->getKindValue($kind),
			                   APPLY_NAME         => $name,
			                   APPLY_KRNAME       => $name_kr,
			                   APPLY_GENDER       => $application->getGenderValue($gender),
			                   APPLY_DOB          => $dob,
			                   APPLY_NATION       => $nation,
			                   APPLY_PROVINCE     => $province,
			                   APPLY_KGSP         => $kgsp,
			                   APPLY_HOME_UNI     => $home_uni,
			                   APPLY_MAJOR        => $major,
			                   APPLY_CLASS        => $application->getClassValue($sclass),
			                   APPLY_HOME_ADDR    => $home_addr,
			                   APPLY_EMAIL        => $email,
			                   APPLY_PHONE        => $phone,
			                   APPLY_CELL         => $cell,
			                   APPLY_PHOTO        => $photo,
			                   APPLY_CASE_NAME    => $case_nm,
			                   APPLY_CASE_RELATE  => $case_rel,
			                   APPLY_CASE_PHONE   => $case_ph,
			                   APPLY_CASE_ADDR    => $case_addr,
			                   APPLY_MATE_NAME    => $mate_nm,
			                   APPLY_MATE_ID      => $mate_id,
			                   APPLY_MATE_DOB_YY  => $mate_dob[0],
			                   APPLY_MATE_DOB_MM  => $mate_dob[1],
			                   APPLY_MATE_DOB_DD  => $mate_dob[2],
			                   APPLY_PREFER       => $room_prefer,
			                   APPLY_PREFERENCE1  => $match_pre1,
			                   APPLY_PREFERENCE2  => $match_pre2,
			                   APPLY_PREFERENCE3  => $match_pre3,
			                   APPLY_PREFERENCE4  => $match_pre4,
			                   APPLY_PREFERENCE5  => $match_pre5,
			                   APPLY_PREFERENCE6  => $match_pre6,
			                   APPLY_RATE1        => $rate1,
			                   APPLY_RATE2        => $rate2,
			                   APPLY_RATE3        => $rate3,
			                   APPLY_SEL_RATE     => $sel_rate,
			                   APPLY_CHECKIN      => $checkin,
			                   APPLY_CHECKOUT     => $checkout,
			                   APPLY_PERIOD       => $period,
			                   APPLY_FEE_TRANSFER => $fee_transfer,
			                   APPLY_FEE_SUPPORT  => $fee_support,
			                   APPLY_TB_TEST      => $tb_test));

			$application->closeDatabase();
			unset($application);
    	
			include_once("../common/footer_tpl.php");
		}
	}
?>