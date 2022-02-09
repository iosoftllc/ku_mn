<?
	include_once("../../lib/conf.common.php");
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.rFastTemplate.php");
	include_once("../../lib/class.cApplicant.php");

	$no = $_POST["no"];
	if ($no == "") $no = $_GET["no"];

	$tpl = new rFastTemplate("../../tpl/popup");
	$tpl->define(array(main => "application.html"));
	$tpl->define_dynamic(preference_row, "main");

	$applicant = new cApplicant($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $applicantTable, $rateTable, $periodTable, $roomTable, $priceTable, $preferenceTable, $paymentTable);
	$applicant->connectDatabase();

	$applicant->getApplicantInfo($no);

	$name = $applicant->personLastName . ", " . $applicant->personFirstName . " " . $applicant->personMiddleName;
	if ($applicant->applyKind == "L") {
		if ($applicant->currentResident == "Y") $current = "KLCC Current Resident";
		else if ($applicant->currentResident == "N") $current = "KLCC Prospect Resident (Deposit of 200,000 Korean won)";
	} else {
		if ($applicant->currentResident == "Y") $current = "Current Resident";
		else if ($applicant->currentResident == "N") $current = "Prospect Resident (Deposit of 200,000 Korean won)";
	}

	$period = $applicant->linkPeriodCode;
	if ($period) {
		$applicant->getPreferenceList($no, $period);
		for ($i = 0 ; $i < count($applicant->preRateCode); $i++) {
			$preference = "";
			if ($applicant->preRateCode[$i]) {
				$preference = $applicant->getDormitoryValue($applicant->preRateDormitory[$i]) . ": " . $applicant->preRateName[$i] . " " . number_format($applicant->preRatePrice[$i]) . "KRW";
			}
			$tpl->assign(array(PREFERENCE_NUMBER => ($i + 1),
			                   PREFERENCE_RATE   => $preference));
			$tpl->parse(PREFERENCE_ROWS, ".preference_row");
		}
		$period = $applicant->linkPeriodName . ": " . getEnglishDate($applicant->linkPeriodSDate) . " - " . getEnglishDate($applicant->linkPeriodEDate);
	} else $period = "";

	if ($applicant->roomPrefer) $room_prefer = $applicant->roomPrefer;
	else $room_prefer = "No Preference";

	$dob = getEnglishDate($applicant->personBirthDate);
	if (!$dob) $dob = "n/a";
	if ($applicant->personHomeUni) $home_uni = stripslashes($applicant->personHomeUni);
	else $home_uni = "n/a";
	if ($applicant->personHomeAddr) $home_addr = stripslashes($applicant->personHomeAddr);
	else $home_addr = "n/a";

	$tpl->assign(array(APPLY_NUMBER      => $no,
	                   APPLY_STUDENT     => $applicant->personStudentID,
	                   APPLY_NAME        => stripslashes($name),
	                   APPLY_KRNAME      => stripslashes($applicant->personKoreanName),
	                   APPLY_GENDER      => $applicant->getGenderValue($applicant->personGender),
	                   APPLY_DOB         => $dob,
	                   APPLY_NATION      => stripslashes($applicant->personNationality),
	                   APPLY_EMAIL       => $applicant->personEmail,
	                   APPLY_PHONE       => $applicant->personPhone,
	                   APPLY_CELL        => $applicant->personCell,
	                   APPLY_CURRENT     => $current,
	                   APPLY_MAJOR       => stripslashes($applicant->personMajor),
	                   APPLY_CLASS       => $applicant->getClassValue($applicant->personClass),
	                   APPLY_HOME_UNI    => $home_uni,
	                   APPLY_HOME_ADDR   => $home_addr,
	                   APPLY_PREFER      => $room_prefer,
	                   APPLY_MATE_NAME   => stripslashes($applicant->mateName),
	                   APPLY_MATE_DOB    => getEnglishDate($applicant->mateBirthDate),
	                   APPLY_PREFERENCE1 => $applicant->getPreferenceValue($applicant->matchNonSmoker),
	                   APPLY_PREFERENCE2 => $applicant->getPreferenceValue($applicant->matchBedEarly),
	                   APPLY_PREFERENCE3 => $applicant->getPreferenceValue($applicant->matchGetupEarly),
	                   APPLY_PREFERENCE4 => $applicant->getPreferenceValue($applicant->matchSilenceStudy),
	                   APPLY_PREFERENCE5 => $applicant->getPreferenceValue($applicant->matchDayStudy),
	                   APPLY_CASE_NAME   => stripslashes($applicant->contactName),
	                   APPLY_CASE_RELATE => stripslashes($applicant->contactRelation),
	                   APPLY_CASE_PHONE  => $applicant->contactPhone,
	                   APPLY_CASE_ADDR   => stripslashes($applicant->contactAddress),
	                   APPLY_PERIOD      => $period,
	                   APPLY_ROOM        => $applicant->linkRoomCode,
	                   APPLY_DATE        => getEnglishDate(substr($applicant->applyDate, 0, 10)),
	                   APPLY_SETTLE1     => $applicant->getSettleValue($applicant->settleFlag1),
	                   APPLY_SETTLE2     => $applicant->getSettleValue($applicant->settleFlag2),
	                   APPLY_SETTLE3     => $applicant->getSettleValue($applicant->settleFlag3),
	                   APPLY_SETTLE4     => $applicant->getSettleValue($applicant->settleFlag4)));

	$applicant->closeDatabase();
	unset($applicant);

	$tpl->parse(FINAL, "main");
	$tpl->FastPrint(FINAL);
?>