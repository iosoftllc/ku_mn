<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/grad_student_tpl.php");

	$cur_dt = date("Y-m-d");
	//$cur_dt = "2021-08-06";

	if ($mode == "app" && $cur_dt < "2021-08-06") {
		$student->closeDatabase();
		unset($student);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"The online application for the 2021-2nd semester will be from August 6, 2021 to August 12, 2021.\");";
		echo "document.location.href = '../../src/graduate/list_app.php?email=$email&pw=$pw';";
		echo "</script>";
	} else if ($mode == "app" && $cur_dt > "2021-08-12") {
		$student->closeDatabase();
		unset($student);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"The online application for the 2021-2nd semester is now closed.\\n\\nNow we have so many applicants that we couldn¡¯t expect over the limit of occupancy.\\n\\nWaiting list for housing is already full. Thanks\");";
		echo "document.location.href = '../../src/graduate/list_app.php?email=$email&pw=$pw';";
		echo "</script>";
	} else {
		$html_dir = "graduate";
		$html_file = "form_stu";
		$on_load = "";
		include_once("../../src/common/tpl_header.php");

		$tpl->define_dynamic(array(logout_row  => "body",
		                           id_year_row => "body",
		                           year_row    => "body",
		                           month_row   => "body",
		                           passwd_row  => "body"));

		for ($i = date("Y") - 4; $i <= date("Y") + 1; $i++) {
			$tpl->assign(ID_YEAR_VALUE, $i);
			$tpl->parse(ID_YEAR_ROWS, ".id_year_row");
		}
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

		if ($mode == "edit" || $mode == "app") {
			$student->getStudentInfo($no);
			$no = $student->studentNumber;
			$id = $student->studentID;
			$fname = stripslashes($student->studentFirstName);
			$mname = stripslashes($student->studentMiddleName);
			$lname = stripslashes($student->studentLastName);
			$prefer = stripslashes($student->studentPreferName);
			$kname = stripslashes($student->studentKoreanName);
			$gender = $student->studentGender;
			$dob_dt = $student->studentDOB;
			$dob = explode("-", $dob_dt);
			$nationality = stripslashes($student->studentNationality);
			$province = stripslashes($student->studentProvince);
			$kgsp = $student->studentKGSP;
			$university = stripslashes($student->studentUniversity);
			$address = stripslashes($student->studentAddress);
			$line1 = stripslashes($student->studentAddrLine1);
			$line2 = stripslashes($student->studentAddrLine2);
			$city = stripslashes($student->studentAddrCity);
			$state = stripslashes($student->studentAddrState);
			$postal = stripslashes($student->studentAddrPostal);
			$country = stripslashes($student->studentAddrCountry);
			$address1 = stripslashes($student->studentAddress1);
			$major = stripslashes($student->studentMajor);
			$class = $student->studentClass;
			$email = $student->studentEmail;
			$phone = $student->studentPhone;
			$mobile = $student->studentMobile;
			$case_name = stripslashes($student->studentCaseName);
			$case_relate = stripslashes($student->studentCaseRelate);
			$case_phone = $student->studentCasePhone;
			$case_addr = stripslashes($student->studentCaseAddress);
			$photo = getOriginalImage("$pht_dir/$no.jpg");//getUploadImage("$pht_dir/$no.jpg");
			$title_img = "<td width=\"232\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_personal_info.jpg\" width=\"232\" height=\"23\"></td>";
			$tpl->parse(LOGOUT_ROWS, ".logout_row");
		} else {
			$mode = "new";
			$no = "";
			$id = "";
			$fname = "";
			$mname = "";
			$lname = "";
			$prefer = "";
			$kname = "";
			$gender = "M";
			$dob_dt = "";
			$dob = array();
			$nationality = "";
			$province = "";
			$kgsp = "N";
			$university = "";
			$address = "";
			$line1 = "";
			$line2 = "";
			$city = "";
			$state = "";
			$postal = "";
			$country = "";
			$address1 = "";
			$major = "";
			$class = "M";
			$email = "";
			$phone = "";
			$mobile = "";
			$case_name = "";
			$case_relate = "";
			$case_phone = "";
			$case_addr = "";
			$admin = "";
			$photo = "";
			$title_img = "<td width=\"243\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_register_stu.jpg\" width=\"243\" height=\"23\"></td>";
		}

		if ($mode == "app") {
			$msg = "Please confirm or update your personal and contact information, all of the following are required to continue.<br><br>";
			$msg .= "<b>Note: You are responsible for updating and frequently checking the email address provided. All formal correspondence, including your room assignment letter will be made via this address.</b><br><br>";
		} else if ($mode == "new") $msg = "To properly establish your account, please enter the following information and click on continue.<br><br>";
		else $msg = "";

		$tpl->assign(array(MODE                => $mode,
		                   TITLE_IMAGE         => $title_img,
		                   STUDENT_NUMBER      => $no,
		                   STUDENT_PASSWORD    => $pw,
		                   STUDENT_ID          => $id,
		                   STUDENT_FIRST_NAME  => $fname,
		                   STUDENT_MIDDLE_NAME => $mname,
		                   STUDENT_LAST_NAME   => $lname,
		                   STUDENT_PREFER_NAME => $prefer,
		                   STUDENT_KOREAN_NAME => $kname,
		                   STUDENT_GENDER      => $gender,
		                   STUDENT_DOB         => getEnglishDate($dob_dt),
		                   STUDENT_DOB_YY      => $dob[0],
		                   STUDENT_DOB_MM      => $dob[1],
		                   STUDENT_DOB_DD      => $dob[2],
		                   STUDENT_NATIONALITY => $nationality,
		                   STUDENT_PROVINCE    => $province,
		                   STUDENT_KGSP        => $kgsp,
		                   STUDENT_UNIVERSITY  => $university,
		                   STUDENT_ADDRESS     => $address,
		                   STUDENT_LINE1       => $line1,
		                   STUDENT_LINE2       => $line2,
		                   STUDENT_CITY        => $city,
		                   STUDENT_STATE       => $state,
		                   STUDENT_POSTAL      => $postal,
		                   STUDENT_COUNTRY     => $country,
		                   STUDENT_ADDRESS1    => $address1,
		                   STUDENT_MAJOR       => $major,
		                   STUDENT_CLASS       => $class,
		                   STUDENT_EMAIL       => $email,
		                   STUDENT_PHONE       => $phone,
		                   STUDENT_MOBILE      => $mobile,
		                   STUDENT_PHOTO       => $photo,
		                   STUDENT_CASE_NAME   => $case_name,
		                   STUDENT_CASE_RELATE => $case_relate,
		                   STUDENT_CASE_PHONE  => $case_phone,
		                   STUDENT_CASE_ADDR   => $case_addr,
		                   STUDENT_MESSAGE     => $msg));

	 if ($mode == "new") $tpl->parse(PASSWD_ROWS, ".passwd_row");

		$student->closeDatabase();
		unset($student);

		include_once("../../src/common/tpl_footer.php");
		include_once("../../src/common/counter_tpl.php");
	}
?>