<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/student_tpl.php");
			include_once("../common/header_tpl.php");

			$tpl->define_dynamic(array(year_row    => "body",
			                           month_row   => "body",
			                           pw_new_row  => "body",
			                           pw_edit_row => "body"));

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

			if ($mode == "edit") {
				$page_name .= " 수정";
				$student->getStudentInfo($no);
				$kind = $student->studentKind;
				$current = $student->studentCurrent;
				$id = $student->studentID;
				$fname = stripslashes($student->studentFirstName);
				$mname = stripslashes($student->studentMiddleName);
				$lname = stripslashes($student->studentLastName);
				$prefer = stripslashes($student->studentPreferName);
				$kname = stripslashes($student->studentKoreanName);
				$gender = $student->studentGender;
				$dob = explode("-", $student->studentDOB);
				$nationality = stripslashes($student->studentNationality);
				$university = stripslashes($student->studentUniversity);
				$address = stripslashes($student->studentAddress);
				$addr1 = stripslashes($student->studentAddr1);
				$addr2 = stripslashes($student->studentAddr2);
				$city = stripslashes($student->studentAddrCity);
				$state = stripslashes($student->studentAddrState);
				$postal = stripslashes($student->studentAddrPostal);
				$country = stripslashes($student->studentAddrCountry);
				$address1 = stripslashes($student->studentAddress1);
				$major = stripslashes($student->studentMajor);
				$class = $student->studentClass;
				$kgsp = $student->studentKGSP;
				$email = $student->studentEmail;
				$phone = $student->studentPhone;
				$mobile = $student->studentMobile;
				$case_name = stripslashes($student->studentCaseName);
				$case_relate = stripslashes($student->studentCaseRelate);
				$case_phone = $student->studentCasePhone;
				$case_addr = stripslashes($student->studentCaseAddress);
				$account = $student->studentAccount;
				$admin = stripslashes($student->studentAdmin);
				$photo = getUploadImage("$pht_dir/$no.jpg");
			} else {
				$page_name .= " 추가";
				$no = "";
				$kind = "";
				$current = "Y";
				$id = "";
				$fname = "";
				$mname = "";
				$lname = "";
				$prefer = "";
				$kname = "";
				$gender = "M";
				$dob = array();
				$nationality = "";
				$university = "";
				$address = "";
				$addr1 = "";
				$addr2 = "";
				$city = "";
				$state = "";
				$postal = "";
				$country = "";
				$address1 = "";
				$major = "";
				$class = "F";
				$kgsp = "N";
				$email = "";
				$phone = "";
				$mobile = "";
				$case_name = "";
				$case_relate = "";
				$case_phone = "";
				$case_addr = "";
				$account = "";
				$admin = "";
				$photo = "";
			}

			$tpl->assign(array(MODE                => $mode,
			                   SEL_PAGE            => $page,
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
			                   STUDENT_KIND        => $kind,
			                   STUDENT_CURRENT     => $current,
			                   STUDENT_ID          => $id,
			                   STUDENT_FIRST_NAME  => $fname,
			                   STUDENT_MIDDLE_NAME => $mname,
			                   STUDENT_LAST_NAME   => $lname,
			                   STUDENT_PREFER_NAME => $prefer,
			                   STUDENT_KOREAN_NAME => $kname,
			                   STUDENT_GENDER      => $gender,
			                   STUDENT_DOB_YY      => $dob[0],
			                   STUDENT_DOB_MM      => $dob[1],
			                   STUDENT_DOB_DD      => $dob[2],
			                   STUDENT_NATIONALITY => $nationality,
			                   STUDENT_UNIVERSITY  => $university,
			                   STUDENT_ADDRESS     => $address,
			                   STUDENT_ADDR1       => $addr1,
			                   STUDENT_ADDR2       => $addr2,
			                   STUDENT_CITY        => $city,
			                   STUDENT_STATE       => $state,
			                   STUDENT_POSTAL      => $postal,
			                   STUDENT_COUNTRY     => $country,
			                   STUDENT_ADDRESS1    => $address1,
			                   STUDENT_MAJOR       => $major,
			                   STUDENT_CLASS       => $class,
			                   STUDENT_KGSP        => $kgsp,
			                   STUDENT_EMAIL       => $email,
			                   STUDENT_PHONE       => $phone,
			                   STUDENT_MOBILE      => $mobile,
			                   STUDENT_PHOTO       => $photo,
			                   STUDENT_CASE_NAME   => $case_name,
			                   STUDENT_CASE_RELATE => $case_relate,
			                   STUDENT_CASE_PHONE  => $case_phone,
			                   STUDENT_CASE_ADDR   => $case_addr,
			                   STUDENT_ACCOUNT     => $account,
			                   STUDENT_ADMIN       => $admin));

			if ($mode == "edit") $tpl->parse(PW_EDIT_ROWS, ".pw_edit_row");
			else $tpl->parse(PW_NEW_ROWS, ".pw_new_row");

			$student->closeDatabase();
			unset($student);

			include_once("../common/footer_tpl.php");
		}
	}
?>