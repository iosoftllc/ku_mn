<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 7 && (int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/student_tpl.php");
			include_once("../common/header_tpl.php");

			$page_name .= " 상세정보 보기";

			$student->getStudentInfo($no);
			if ($student->studentLastName) $name = stripslashes($student->studentLastName . ", " . $student->studentFirstName . " " . $student->studentMiddleName);
			else $name = stripslashes($student->studentFirstName . " " . $student->studentMiddleName);
			if ($student->studentPreferName) $preferred = "(" . stripslashes($student->studentPreferName) . ")";
			else $preferred = "";
			$tpl->assign(array(SEL_PAGE            => $page,
			                   SEARCH_TYPE         => $s_type,
			                   SEARCH_TEXT         => $s_text,
			                   SEARCH_KIND         => $s_kind,
			                   SEARCH_CURRENT      => $s_current,
			                   SEARCH_YEAR1        => $s_year1,
			                   SEARCH_MONTH1       => $s_month1,
			                   SEARCH_DAY1         => $s_day1,
			                   SEARCH_YEAR2        => $s_year2,
			                   SEARCH_MONTH2       => $s_month2,
			                   SEARCH_DAY2         => $s_day2,
			                   SORT1_VALUE         => $sort1,
			                   SORT2_VALUE         => $sort2,
			                   STUDENT_NUMBER      => $no,
			                   STUDENT_KIND        => $student->getKindValue($student->studentKind),
			                   STUDENT_CURRENT     => $student->getCurrentValue($student->studentCurrent),
			                   STUDENT_ID          => $student->studentID,
			                   STUDENT_NAME        => stripslashes($name),
			                   STUDENT_PREFERRED   => $preferred,
			                   STUDENT_KOREAN_NAME => stripslashes($student->studentKoreanName),
			                   STUDENT_GENDER      => $student->getGenderValue($student->studentGender),
			                   STUDENT_DOB         => getFullDate($student->studentDOB),
			                   STUDENT_NATIONALITY => stripslashes($student->studentNationality),
			                   STUDENT_UNIVERSITY  => stripslashes($student->studentUniversity),
			                   STUDENT_ADDRESS     => getAddressValue($student->studentAddress, $student->studentAddr1, $student->studentAddr2, $student->studentAddrCity, $student->studentAddrState, $student->studentAddrCountry, $student->studentAddrPostal),
			                   STUDENT_ADDRESS1    => stripslashes($student->studentAddress1),
			                   STUDENT_MAJOR       => stripslashes($student->studentMajor),
			                   STUDENT_CLASS       => $student->getClassValue($student->studentClass),
			                   STUDENT_KGSP        => $student->getKGSPValue($student->studentKGSP),
			                   STUDENT_EMAIL       => $student->studentEmail,
			                   STUDENT_PHONE       => $student->studentPhone,
			                   STUDENT_MOBILE      => $student->studentMobile,
			                   STUDENT_PHOTO       => getOriginalImage("$pht_dir/$no.jpg"),
			                   STUDENT_CASE_NAME   => stripslashes($student->studentCaseName),
			                   STUDENT_CASE_RELATE => stripslashes($student->studentCaseRelate),
			                   STUDENT_CASE_PHONE  => $student->studentCasePhone,
			                   STUDENT_CASE_ADDR   => stripslashes($student->studentCaseAddress),
			                   STUDENT_ACCOUNT     => $student->studentAccount,
			                   STUDENT_DATE        => getFullDate($student->studentDate),
			                   STUDENT_ADMIN       => nl2br(stripslashes($student->studentAdmin))));

			$detail = $student->studentID . " 학번 상세 정보 조회";
			$student->insertHistoryWork("S", "I", $detail);

			$student->closeDatabase();
			unset($student);

			include_once("../common/footer_tpl.php");
		}
	}
?>