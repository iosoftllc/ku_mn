<?
	include_once("../../lib/conf.common.php");
	include_once("../../lib/class.cApplicant.php");

	$type = $_POST["type"];
	$code = $_POST["code"];
	if ($type == "") $type = $_GET["type"];
	if ($code == "") $code = $_GET["code"];

	$applicant = new cApplicant($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $applicantTable, $rateTable, $periodTable, $roomTable, $priceTable, $preferenceTable, $paymentTable);
	$applicant->connectDatabase();

	echo "<?xml version='1.0' encoding='EUC-KR'?>";
	echo "<xml>";
	switch ($type) {
		case "rate":
			$applicant->getRateList($code);
			for ($i = 0; $i < count($applicant->rateCode); $i++) {
				if (($code == "2006SA" || $code == "2006SB") && ($applicant->rateCode[$i] == "3BSS" || $applicant->rateCode[$i] == "3BSD" || $applicant->rateCode[$i] == "4BSD")) continue;
				echo "<district>";
				echo "<code>" . $applicant->rateCode[$i] . "</code>";
				echo "<dorm>" . $applicant->getDormitoryValue($applicant->rateDormitory[$i], $applicant->rateCode[$i]) . "</dorm>";
				echo "<name>" . stripslashes($applicant->rateName[$i]) . "</name>";
				echo "<price>" . number_format($applicant->ratePrice[$i]) . " KRW" . "</price>";
				echo "</district>";
			}
			break;
	}
	echo "</xml>";

	$applicant->closeDatabase();
	unset($applicant);
?>