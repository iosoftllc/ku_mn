<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/grad_application_tpl.php");
	include_once("../../lib/class.rFastTemplate.php");

	$tpl = new rFastTemplate("../../tpl/popup");
	$tpl->define(array(main => "grad_application.html"));
	$tpl->define_dynamic(preference_row, "main");

	$application->getApplicationInfo($no);

	$name = $application->personLastName . ", " . $application->personFirstName . " " . $application->personMiddleName;
	if ($application->personPreferName) $preferred = "(" . $application->personPreferName . ")";
	else $preferred = "";
	if ($application->currentResident == "Y") $current = "Current Resident";
	else if ($application->currentResident == "N") $current = "Prospect Resident (Deposit of 200,000 Korean won)";

	$period = $application->linkPeriodCode;
	if ($period) {
		$application->getPreferenceList($no, $period);
		for ($i = 0 ; $i < count($application->preRateCode); $i++) {
			$preference = "";
			if ($application->preRateCode[$i]) {
				$preference = $application->preRateName[$i] . " : " . number_format($application->preRatePrice[$i]) . "KRW";
			}
			$tpl->assign(array(PREFERENCE_NUMBER => ($i + 1),
			                   PREFERENCE_RATE   => $preference));
			$tpl->parse(PREFERENCE_ROWS, ".preference_row");
		}
		$period = $application->linkPeriodName . ": " . getEnglishDate($application->linkPeriodSDate) . " - " . getEnglishDate($application->linkPeriodEDate);
	} else $period = "";

	if ($application->roomPrefer) $room_prefer = $application->roomPrefer;
	else $room_prefer = "No Preference";

	$dob = getEnglishDate($application->personBirthDate);
	if (!$dob) $dob = "n/a";
	if ($application->personHomeUni) $home_uni = stripslashes($application->personHomeUni);
	else $home_uni = "n/a";
	if ($application->personHomeAddr) $home_addr = stripslashes($application->personHomeAddr);
	else $home_addr = "n/a";

	$acc_no = "391-910012-18304";
	if (trim($application->applyAccount)) $acc_no = trim($application->applyAccount);

	$nation = $application->personNationality;
	if (trim($application->personProvince) != "") $nation .= " - " . $application->personProvince;

	$tpl->assign(array(APPLY_NUMBER      => $no,
	                   APPLY_STUDENT     => $application->personStudentID,
	                   APPLY_NAME        => stripslashes($name),
	                   APPLY_PREFERRED   => stripslashes($preferred),
	                   APPLY_KRNAME      => stripslashes($application->personKoreanName),
	                   APPLY_GENDER      => $application->getGenderValue($application->personGender),
	                   APPLY_DOB         => $dob,
	                   APPLY_NATION      => stripslashes($nation),
	                   APPLY_EMAIL       => $application->personEmail,
	                   APPLY_PHONE       => $application->personPhone,
	                   APPLY_CELL        => $application->personCell,
	                   APPLY_CURRENT     => $current,
	                   APPLY_MAJOR       => stripslashes($application->personMajor),
	                   APPLY_CLASS       => $application->getClassValue($application->personClass),
	                   APPLY_HOME_UNI    => $home_uni,
	                   APPLY_HOME_ADDR   => $home_addr,
	                   APPLY_PREFER      => $room_prefer,
	                   APPLY_MATE_NAME   => stripslashes($application->mateName),
	                   APPLY_MATE_ID     => stripslashes($application->mateID),
	                   APPLY_MATE_DOB    => getEnglishDate($application->mateBirthDate),
	                   APPLY_PREFERENCE1 => $application->getPreferenceValue($application->matchNonSmoker),
	                   APPLY_PREFERENCE2 => $application->getPreferenceValue($application->matchBedEarly),
	                   APPLY_PREFERENCE3 => $application->getPreferenceValue($application->matchGetupEarly),
	                   APPLY_PREFERENCE4 => $application->getPreferenceValue($application->matchSilenceStudy),
	                   APPLY_PREFERENCE5 => $application->getPreferenceValue($application->matchDayStudy),
	                   APPLY_PREFERENCE6 => $application->getPreferenceValue($application->matchLocal),
	                   APPLY_CASE_NAME   => stripslashes($application->contactName),
	                   APPLY_CASE_RELATE => stripslashes($application->contactRelation),
	                   APPLY_CASE_PHONE  => $application->contactPhone,
	                   APPLY_CASE_ADDR   => stripslashes($application->contactAddress),
	                   APPLY_PERIOD      => $period,
	                   APPLY_ROOM        => $application->linkRoomCode,
	                   APPLY_DATE        => getEnglishDate(substr($application->applyDate, 0, 10)),
	                   APPLY_SETTLE1     => $application->getSettleValue($application->settleFlag1),
	                   APPLY_SETTLE2     => $application->getSettleValue($application->settleFlag2),
	                   APPLY_SETTLE3     => $application->getSettleValue($application->settleFlag3),
	                   APPLY_SETTLE4     => $application->getSettleValue($application->settleFlag4),
	                   APPLY_ACCOUNT     => $acc_no));

	include("../common/tpl_variables.php");

	$application->closeDatabase();
	unset($application);

	$tpl->parse(FINAL, "main");
	$tpl->FastPrint(FINAL);
?>