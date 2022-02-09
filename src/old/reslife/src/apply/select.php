<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../common/apply_tpl.php");

		$type = $_POST["type"];
		$code = $_POST["code"];
		if ($type == "") $type = $_GET["type"];
		if ($code == "") $code = $_GET["code"];

		echo "<?xml version='1.0' encoding='EUC-KR'?>";
		echo "<xml>";
		switch ($type) {
			case "rate":
				$applicant->getRateList($code);
				for ($i = 0; $i < count($applicant->rateCode); $i++) {
					echo "<district>";
					echo "<code>" . $applicant->rateCode[$i] . "</code>";
					echo "<dorm>" . $applicant->getDormitoryValue($applicant->rateDormitory[$i]) . "</dorm>";
					echo "<name>" . stripslashes($applicant->rateName[$i]) . "</name>";
					echo "<price>" . number_format($applicant->ratePrice[$i]) . "KRW" . "</price>";
					echo "</district>";
				}
				break;
		}
		echo "</xml>";

		$applicant->closeDatabase();
		unset($applicant);
	}
?>