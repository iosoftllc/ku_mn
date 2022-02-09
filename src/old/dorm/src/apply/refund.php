<?
	include_once("../../lib/conf.common.php");

	$html_dir = "apply";
	$html_file = "refund";
	$on_load = "document.RefundForm.student.focus();";

	include_once("../../lib/func.common.php");
	include_once("../../src/common/tpl_header.php");

		$tpl->define_dynamic(array(year_row     => "body",
		                           month_row    => "body",
		                           room_row     => "body",
		                           period_row   => "body"));

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

/*
		if ($current == "Y") $tpl->parse(ROOM_ROWS, ".room_row");

		$applicant->getPeriodList($s_kind);
		for ($i = 0; $i < count($applicant->periodCode); $i++) {
			$temp = "";
			if ($applicant->periodCode[$i]) $temp = $applicant->periodName[$i] . ": " . getEnglishDate($applicant->periodSDate[$i]) . " - " . getEnglishDate($applicant->periodEDate[$i]);
			$tpl->assign(array(PEDIOD_VALUE => $applicant->periodCode[$i],
			                   PEDIOD_NAME  => $temp));
			$tpl->parse(PERIOD_ROWS, ".period_row");
		}

		$dob = explode("-", $applicant->personBirthDate);
		if ($applicant->personHomeUni) $home_uni = stripslashes($applicant->personHomeUni);
		$home_uni = "";
		$tpl->assign(array(CURRENT_KIND       => $kind,
		                   CURRENT_VALUE      => $current,
		                   TITLE_IMAGE        => $title_img,
		                   ID_TITLE           => $id_title,
		                   ID_SIZE            => $id_size,
		                   APPLY_GENDER       => $applicant->personGender,
		                   APPLY_DOB_YY       => $dob[0],
		                   APPLY_DOB_MM       => $dob[1],
		                   APPLY_DOB_DD       => $dob[2],
		                   APPLY_STUDENT      => $applicant->personStudentID,
		                   APPLY_FNAME        => stripslashes($applicant->personFirstName),
		                   APPLY_MNAME        => stripslashes($applicant->personMiddleName),
		                   APPLY_LNAME        => stripslashes($applicant->personLastName),
		                   APPLY_KRNAME       => stripslashes($applicant->personKoreanName),
		                   APPLY_NATIONALITY  => stripslashes($applicant->personNationality),
		                   APPLY_HOME_UNI     => $home_uni,
		                   APPLY_MAJOR        => stripslashes($applicant->personMajor),
		                   APPLY_HOME_ADDR    => stripslashes($applicant->personHomeAddr),
		                   APPLY_EMAIL        => $applicant->personEmail,
		                   APPLY_PHONE        => $applicant->personPhone,
		                   APPLY_CELL         => $applicant->personCell,
		                   EMERGENCY_NAME     => stripslashes($applicant->contactName),
		                   EMERGENCY_RELATION => stripslashes($applicant->contactRelation),
		                   EMERGENCY_PHONE    => $applicant->contactPhone,
		                   EMERGENCY_ADDR     => stripslashes($applicant->contactAddress)));

		$applicant->closeDatabase();
		unset($applicant);
*/
		include_once("../../src/common/tpl_footer.php");
		include_once("../../src/common/counter_tpl.php");
?>