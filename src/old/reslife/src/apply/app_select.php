<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../common/application_tpl.php");

		$type = $_POST["type"];
		$code = $_POST["code"];
		if ($type == "") $type = $_GET["type"];
		if ($code == "") $code = $_GET["code"];

		Header("Content-Type: text/xml");
		echo "<?xml version='1.0' encoding='EUC-KR'?>";
		echo "<xml>";
		switch ($type) {
			case "rate":
				$application->getRateList($code);
				for ($i = 0; $i < count($application->rateCode); $i++) {
					echo "<district>";
					echo "<code>" . $application->rateCode[$i] . "</code>";
					echo "<dorm>" . $application->getDormitoryValue($application->rateDormitory[$i], $application->rateCode[$i]) . "</dorm>";
					echo "<name>" . stripslashes($application->rateName[$i]) . "</name>";
					echo "<price>" . number_format($application->ratePrice[$i]) . "KRW" . "</price>";
					echo "</district>";
				}
				break;
		}
		echo "</xml>";

		$application->closeDatabase();
		unset($application);
	}
?>