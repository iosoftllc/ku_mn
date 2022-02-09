<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/grad_student_tpl.php");

	$on_load = "";

	if (!$student->isEmailExist($email)) {
		$student->closeDatabase();
		unset($student);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"There is not correspondant information.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if (!$student->checkPassword($email, $pw)) {
		$student->closeDatabase();
		unset($student);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"The password you input is not correct.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else {
		$html_dir = "graduate";
		$html_file = "view_stu";
		include_once("../../src/common/tpl_header.php");

		$no = $student->getStudentNumber($email);
		$student->getStudentInfo($no);
		if ($student->studentLastName) $name = stripslashes($student->studentLastName . ", " . $student->studentFirstName . " " . $student->studentMiddleName);
		else $name = stripslashes($student->studentFirstName . " " . $student->studentMiddleName);
		if ($student->studentPreferName) $preferred = "(" . stripslashes($student->studentPreferName) . ")";
		else $preferred = "";

		$nation = $student->studentNationality;
		if (trim($student->studentProvince) != "") $nation .= " - " . $student->studentProvince;

		$tpl->assign(array(STUDENT_NUMBER      => $no,
		                   STUDENT_PASSWORD    => $pw,
		                   STUDENT_CURRENT     => $student->getCurrentValue($student->studentCurrent),
		                   STUDENT_ID          => $student->studentID,
		                   STUDENT_NAME        => stripslashes($name),
		                   STUDENT_PREFERRED   => $preferred,
		                   STUDENT_KOREAN_NAME => stripslashes($student->studentKoreanName),
		                   STUDENT_GENDER      => $student->getGenderValue($student->studentGender),
		                   STUDENT_DOB         => getFullDate($student->studentDOB),
		                   STUDENT_NATIONALITY => stripslashes($nation),
		                   STUDENT_KGSP        => $student->getKGSPValue($student->studentKGSP),
		                   STUDENT_UNIVERSITY  => stripslashes($student->studentUniversity),
		                   STUDENT_ADDRESS     => getAddressValue($student->studentAddress, $student->studentAddr1, $student->studentAddr2, $student->studentAddrCity, $student->studentAddrState, $student->studentAddrCountry, $student->studentAddrPostal),
		                   STUDENT_MAJOR       => stripslashes($student->studentMajor),
		                   STUDENT_CLASS       => $student->getClassValue($student->studentClass),
		                   STUDENT_EMAIL       => $student->studentEmail,
		                   STUDENT_PHONE       => $student->studentPhone,
		                   STUDENT_MOBILE      => $student->studentMobile,
		                   STUDENT_PHOTO       => getOriginalImage("$pht_dir/$no.jpg"),
		                   STUDENT_CASE_NAME   => stripslashes($student->studentCaseName),
		                   STUDENT_CASE_RELATE => stripslashes($student->studentCaseRelate),
		                   STUDENT_CASE_PHONE  => $student->studentCasePhone,
		                   STUDENT_CASE_ADDR   => stripslashes($student->studentCaseAddress)));

		$student->getPlacementInfo($email);
		$place_term = "";
		if ($student->linkPeriodCode) $place_term = $student->linkPeriodName . " : " . $student->linkPeriodRateName . " (" . getEnglishDate($student->linkPeriodSDate) . " - " . getEnglishDate($student->linkPeriodEDate) . ")";
		$place_ip = "";
		if ($student->linkRoomIP) {
			$place_ip .= "IP Address : " . $student->linkRoomIP . "<br>";
			$temp_ip = explode(".", $student->linkRoomIP);
			$place_ip .= "Subnet Mask : 255.255.255.0<br>";
			$place_ip .= "GateWay : " . $temp_ip[0] . "." . $temp_ip[1] . "." . $temp_ip[2] . ".1<br>";
			$place_ip .= "Main DNS Server : 219.252.0.1<br>";
			$place_ip .= "Ass. DNS server : 219.252.1.100";
		}
		$place_addr = "";
		if ($student->linkRoomCode) $place_addr = $student->linkRoomCode . "<br>Anam Global House<br>Korea University<br>Anam-Dong Seongbuk-Gu<br>Seoul, 136-701 Korea";
		$tpl->assign(array(PLACE_TERM    => $place_term,
		                   PLACE_ADDRESS => $place_addr,
		                   PLACE_PHONE   => $student->linkRoomPhone,
		                   PLACE_IP      => $place_ip));

		$student->closeDatabase();
		unset($student);
	
		include_once("../../src/common/tpl_footer.php");
		include_once("../../src/common/counter_tpl.php");
	}
?>