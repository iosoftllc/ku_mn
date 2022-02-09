<?
	include_once("../../lib/conf.common.php");
	include_once("../common/faculty_tpl.php");
	include_once("../../lib/class.rFastTemplate.php");

	$tpl = new rFastTemplate("../../tpl/popup");
	$tpl->define(array(main => "application_f.html"));

	$faculty->getFacultyInfo($no);
	$rate = $faculty->facultyRate;
	$arrival = $faculty->facultyArrival;
	$departure = $faculty->facultyDeparture;
	if ($faculty->facultyAccount) $account = $faculty->facultyAccount;
	else $account = "391-910001-03204";

	$room_info = "";
	$faculty->getRoomValue($no);
	for ($i = 0; $i < count($faculty->roomCode); $i++) {
		$room_info .= $faculty->roomCode[$i] . ",";
	}
	if ($room_info) $room_info = substr($room_info, 0, -1);

	$name = "";
	if ($faculty->facultyTitle) $name .= $faculty->facultyTitle . ". ";
	$name .= $faculty->facultyLName;
	if (trim($faculty->facultyFName)) $name .= ", " . $faculty->facultyFName . " " . $faculty->facultyMName;
	$reference = $faculty->facultyRLName;
	if (trim($faculty->facultyRFName)) $reference .= ", " . $faculty->facultyRFName . " " . $faculty->facultyRMName;

	$tpl->assign(array(FACULTY_NUMBER    => $no,
	                   FACULTY_NAME      => stripslashes($name),
	                   FACULTY_KOREAN    => stripslashes($faculty->facultyKName),
	                   FACULTY_EMPLOY    => stripslashes($faculty->facultyEmployee),
	                   FACULTY_PURPOSE   => stripslashes($faculty->facultyPurpose),
	                   FACULTY_KDEPART   => stripslashes($faculty->facultyKDepart),
	                   FACULTY_KPOS      => stripslashes($faculty->facultyKPosition),
	                   FACULTY_HDEPART   => stripslashes($faculty->facultyHDepart),
	                   FACULTY_HPOS      => stripslashes($faculty->facultyHPosition),
	                   FACULTY_NATION    => stripslashes($faculty->facultyNationality),
	                   FACULTY_DOB       => getEnglishDate($faculty->facultyDOB),
	                   FACULTY_COUNTRY   => stripslashes($faculty->facultyCountry),
	                   FACULTY_EMAIL     => $faculty->facultyEmail,
	                   FACULTY_PHONE     => stripslashes($faculty->facultyPhone),
	                   FACULTY_ARRIVAL   => getEnglishDate($arrival),
	                   FACULTY_DEPARTURE => getEnglishDate($departure),
	                   FACULTY_PAY       => $faculty->getPaymentMethod($faculty->facultyPMethod),
	                   FACULTY_RATE      => stripslashes($faculty->getDormitoryValue1($faculty->facultyDormitory) . " - " . $faculty->facultyUnit),
	                   FACULTY_NO_ROOM   => $faculty->facultyNoRoom,
	                   FACULTY_DATE      => getEnglishDate($faculty->facultyDate),
	                   FACULTY_RNAME     => stripslashes($reference),
	                   FACULTY_RDEPART   => stripslashes($faculty->facultyRDepart),
	                   FACULTY_RPOS      => stripslashes($faculty->facultyRPosition),
	                   FACULTY_REMAIL    => $faculty->facultyREmail,
	                   FACULTY_RPHONE    => stripslashes($faculty->facultyRPhone),
	                   FACULTY_ROOM      => $room_info,
	                   FACULTY_ACCOUNT   => $account));

	include("../common/tpl_variables.php");

	$faculty->closeDatabase();
	unset($faculty);

	$tpl->parse(FINAL, "main");
	$tpl->FastPrint(FINAL);
?>