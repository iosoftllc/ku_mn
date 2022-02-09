<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/application_tpl.php");

	$cur_dt = date("Y-m-d");
	$cur_time = date("H");
	//$cur_dt = "2021-06-07";
	//$cur_time = 12;

	if ($cur_dt < "2021-06-07") {
		$application->closeDatabase();
		unset($application);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"The online application for the Fall 2021 term will be from June 7, 2021 to July 2, 2021.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($cur_dt > "2021-07-02") {
		$application->closeDatabase();
		unset($application);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"The online application for the Fall 2021 term is now closed.\\n\\nNow we have so many applicants that we couldn¡¯t expect over the limit of occupancy.\\n\\nWaiting list for housing is already full. Thanks\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if (!$application->isEmailExist($email)) {
		$application->closeDatabase();
		unset($application);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"There is no matching personal data available.\\n\\nCheck your personal information.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if (!$application->checkPassword($email, $pw)) {
		$application->closeDatabase();
		unset($application);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"The password you input is not correct.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else {
		$stu_no = $application->getStudentNumber($email);
		$application->getStudentInfo($stu_no);
		$html_dir = "apply";
		$html_file = "form_app";
		$on_load = "";

		$kind = $application->studentKind;
		$current = $application->studentCurrent;

		if ($kind == "L") {
			$s_kind = "LAN";
			$id_title = "Korean Language & Culture Center Student ID";
			if ($current == "Y") $title_img = "<td width=\"311\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_l.jpg\" width=\"501\" height=\"23\"></td>";
			else $title_img = "<td width=\"311\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_l.jpg\" width=\"501\" height=\"23\"></td>";
		} else {
			$s_kind = "GEN";
			$id_title = "Korea University Student ID No";
			//if ($current == "Y") $title_img = "<td width=\"311\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_c.jpg\" width=\"311\" height=\"23\"></td>";
			//else $title_img = "<td width=\"318\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_n.jpg\" width=\"318\" height=\"23\"></td>";
			$title_img = "<td width=\"251\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_new.jpg\" width=\"251\" height=\"23\"></td>";
		}

		include_once("../../src/common/tpl_header.php");

		$tpl->define_dynamic(array(year_row    => "body",
		                           month_row   => "body",
		                           room_row    => "body",
		                           period_row  => "body",
		                           deposit_row => "body"));

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

		$application->getPeriodList($s_kind, $current);
		for ($i = 0; $i < count($application->periodCode); $i++) {
			$temp = "";
			if ($application->periodCode[$i]) $temp = $application->periodName[$i] . ": " . getEnglishDate($application->periodSDate[$i]) . " - " . getEnglishDate($application->periodEDate[$i]);
			$tpl->assign(array(PEDIOD_VALUE => $application->periodCode[$i],
			                   PEDIOD_NAME  => $temp));
			$tpl->parse(PERIOD_ROWS, ".period_row");
		}

		if ($mode == "edit") {
			$application->getApplicationInfo($no);
			$period = $application->linkPeriodCode;
			$application->getPreferenceList($no, $application->linkPeriodCode);
			$rate1 = $application->preRateCode[0];
			$rate2 = $application->preRateCode[1];
			$rate3 = $application->preRateCode[2];
			$rate4 = $application->preRateCode[3];
			$rate5 = $application->preRateCode[4];
			$dorm_waived = $application->dormWaived;
			$room_prefer = $application->roomPrefer;
			$mate_nm = stripslashes($application->mateName);
			$mate_id = stripslashes($application->mateID);
			$match_pre1 = $application->matchNonSmoker;
			$match_pre2 = $application->matchBedEarly;
			$match_pre3 = $application->matchGetupEarly;
			$match_pre4 = $application->matchSilenceStudy;
			$match_pre5 = $application->matchDayStudy;
			$match_pre6 = $application->matchLocal;
		} else {
			$mode = "apply";
			$no = "";
			$period = "";
			$rate1 = "";
			$rate2 = "";
			$rate3 = "";
			$rate4 = "";
			$rate5 = "";
			$dorm_waived = "N";
			$room_prefer = "";
			$mate_nm = "";
			$mate_id = "";
			$match_pre1 = "M";
			$match_pre2 = "M";
			$match_pre3 = "M";
			$match_pre4 = "M";
			$match_pre5 = "M";
			$match_pre6 = "M";
		}

		if ($current == "Y") {
			$tpl->assign(APPLY_PREFER, $room_prefer);
			//$tpl->parse(ROOM_ROWS, ".room_row");
		}

		$tpl->assign(array(MODE               => $mode,
		                   TITLE_IMAGE        => $title_img,
		                   ID_TITLE           => $id_title,
		                   APPLY_CURRENT      => $current,
		                   APPLY_GENDER       => $application->studentGender,
		                   APPLY_DOB          => getFullDate($application->studentDOB),
		                   APPLY_STUDENT      => $application->studentID,
		                   APPLY_FNAME        => stripslashes($application->studentFirstName),
		                   APPLY_MNAME        => stripslashes($application->studentMiddleName),
		                   APPLY_LNAME        => stripslashes($application->studentLastName),
		                   APPLY_KRNAME       => stripslashes($application->studentKoreanName),
		                   APPLY_NATIONALITY  => stripslashes($application->studentNationality),
		                   APPLY_HOME_UNI     => $home_uni = stripslashes($application->studentUniversity),
		                   APPLY_MAJOR        => stripslashes($application->studentMajor),
		                   APPLY_CLASS        => $application->getClassValue($application->studentClass),
		                   APPLY_HOME_ADDR    => stripslashes($application->studentAddress),
		                   APPLY_EMAIL        => $application->studentEmail,
		                   APPLY_PHONE        => $application->studentPhone,
		                   APPLY_CELL         => $application->studentMobile,
		                   APPLY_PHOTO        => getOriginalImage("$pht_dir/$stu_no.jpg"),
		                   EMERGENCY_NAME     => stripslashes($application->studentCaseName),
		                   EMERGENCY_RELATION => stripslashes($application->studentCaseRelate),
		                   EMERGENCY_PHONE    => $application->studentCasePhone,
		                   EMERGENCY_ADDR     => stripslashes($application->studentCaseAddress),
		                   APPLY_NUMBER       => $no,
		                   APPLY_PERIOD       => $period,
		                   APPLY_RATE1        => $rate1,
		                   APPLY_RATE2        => $rate2,
		                   APPLY_RATE3        => $rate3,
		                   APPLY_RATE4        => $rate4,
		                   APPLY_RATE5        => $rate5,
		                   APPLY_MATE_NAME    => $mate_nm,
		                   APPLY_MATE_ID      => $mate_id,
		                   APPLY_PREFERENCE1  => $match_pre1,
		                   APPLY_PREFERENCE2  => $match_pre2,
		                   APPLY_PREFERENCE3  => $match_pre3,
		                   APPLY_PREFERENCE4  => $match_pre4,
		                   APPLY_PREFERENCE5  => $match_pre5,
		                   APPLY_PREFERENCE6  => $match_pre6,
		                   APPLY_DORM_WAIVED  => $dorm_waived,
		                   STUDENT_PASSWORD   => $pw));

		//if ($application->applyState == "DP" || $application->applyState == "DD" || $application->applyState == "RA" || $application->applyState == "FP" || $application->applyState == "FD" || $application->applyState == "FS") $tpl->parse(DEPOSIT_ROWS, ".deposit_row");

		$application->closeDatabase();
		unset($application);

		include_once("../../src/common/tpl_footer.php");
		include_once("../../src/common/counter_tpl.php");
	}
?>