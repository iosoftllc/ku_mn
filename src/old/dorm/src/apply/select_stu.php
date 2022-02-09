<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/application_tpl.php");

	$type = $_POST["type"];
	$code = $_POST["code"];
	$gender = $_POST["gender"];
	if ($type == "") $type = $_GET["type"];
	if ($code == "") $code = $_GET["code"];
	if ($gender == "") $gender = $_GET["gender"];

	Header("Content-Type: text/xml");
	echo "<?xml version='1.0' encoding='EUC-KR'?>\n";
	echo "<result>\n";
	switch ($type) {
		case "rate":
			$application->getRateList($code);
			for ($i = 0; $i < count($application->rateCode); $i++) {
				if (($code == "2006SA" || $code == "2006SB") && ($application->rateCode[$i] == "3BSS" || $application->rateCode[$i] == "3BSD" || $application->rateCode[$i] == "4BSD")) continue;
				if ($gender != "M" && $application->rateCode[$i] == "ANAM") continue;
				echo "<district>\n";
				echo "<code>" . $application->rateCode[$i] . "</code>\n";
				echo "<dorm>" . $application->getDormitoryValue($application->rateDormitory[$i], $application->rateCode[$i]) . "</dorm>\n";
				echo "<name>" . stripslashes($application->rateName[$i]) . "</name>\n";
				echo "<price>" . number_format($application->ratePrice[$i]) . " KRW" . "</price>\n";
				echo "</district>\n";
			}
			break;
	}
	echo "</result>";

	$application->closeDatabase();
	unset($application);
?>