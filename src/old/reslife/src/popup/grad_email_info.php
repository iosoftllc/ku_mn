<?
	include_once("../common/popup_header_tpl.php");
	include_once("../common/grad_application_tpl.php");

	$email = $_GET["email"];
	if (!$email) $email = $_POST["email"];

	$page_title = "이메일 정보 확인 결과";
	$sub_title = "이메일 정보 확인 결과";
	$on_load = "document.CheckEmailForm.email.focus();";

	$student = "";
	$current = "";
	$kind = "";
	$name = "";
	$name_kr = "";
	$gender = "";
	$dob = "";
	$nation = "";
	$kgsp = "";
	$home_uni = "";
	$major = "";
	$sclass = "";
	$home_addr = "";
	$phone = "";
	$cell = "";
	$photo = "";
	$case_nm = "";
	$case_rel = "";
	$case_ph = "";
	$case_addr = "";
	if ($application->isEmailExist($email)) {
		$use_flag = "1";
		$msg = $email . "(은)는 등록되어 있는 이메일입니다.";
		$application->getStudentInfo1($email);
		$student = $application->studentID;
		$current = $application->studentCurrent;
		$kind = $application->studentKind;
		$name = stripslashes($application->studentLastName . ", " . $application->studentFirstName . " " . $application->studentMiddleName);
		$name_kr = stripslashes($application->studentKoreanName);
		$gender = $application->studentGender;
		$dob = $application->studentDOB;
		$nation = stripslashes($application->studentNationality);
		if (trim($application->studentProvince) != "") $nation .= " - " . stripslashes($application->studentProvince);
		$kgsp = $application->getKGSPValue($application->studentKGSP);
		$home_uni = stripslashes($application->studentUniversity);
		$major = stripslashes($application->studentMajor);
		$sclass = $application->studentClass;
		$home_addr = getAddressValue($application->studentAddress, $application->studentAddr1, $application->studentAddr2, $application->studentAddrCity, $application->studentAddrState, $application->studentAddrCountry, $application->studentAddrPostal);
		$phone = $application->studentPhone;
		$cell = $application->studentMobile;
		$photo = getOriginalImage($pht_dir."/".$application->studentNumber.".jpg");
		$case_nm = stripslashes($application->studentCaseName);
		$case_rel = stripslashes($application->studentCaseRelate);
		$case_ph = $application->studentCasePhone;
		$case_addr = stripslashes($application->studentCaseAddress);
	} else if ($email) {
		$use_flag = "0";
		$msg = $email . "(은)는 등록되어 있지 않은 이메일입니다.";
	} else {
		$use_flag = "0";
		$msg = "이메일을 입력하세요.";
	}

	$tpl->assign(array(EMAIL_VALUE      => $email,
	                   MESSAGE          => $msg,
	                   USE_FLAG         => $use_flag,
	                   INFO_STUDENT     => $student,
	                   INFO_CURRENT     => $application->getCurrentValue($current),
	                   INFO_KIND        => $application->getKindValue($kind),
	                   INFO_NAME        => $name,
	                   INFO_KRNAME      => $name_kr,
	                   INFO_GENDER      => $application->getGenderValue($gender),
	                   INFO_DOB         => $dob,
	                   INFO_NATION      => $nation,
	                   INFO_KGSP        => $kgsp,
	                   INFO_HOME_UNI    => $home_uni,
	                   INFO_MAJOR       => $major,
	                   INFO_CLASS       => $application->getClassValue($sclass),
	                   INFO_HOME_ADDR   => $home_addr,
	                   INFO_PHONE       => $phone,
	                   INFO_CELL        => $cell,
	                   INFO_PHOTO       => $photo,
	                   INFO_CASE_NAME   => $case_nm,
	                   INFO_CASE_RELATE => $case_rel,
	                   INFO_CASE_PHONE  => $case_ph,
	                   INFO_CASE_ADDR   => $case_addr));

	$application->closeDatabase();
	unset($application);

	include("../common/popup_footer_tpl.php");
?>