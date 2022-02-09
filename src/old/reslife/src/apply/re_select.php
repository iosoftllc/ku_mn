<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../common/refund_tpl.php");

		$type = $_POST["type"];
		$kind = $_POST["kind"];
		if ($type == "") $type = $_GET["type"];
		if ($kind == "") $kind = $_GET["kind"];
		if ($kind == "L") $kind = "LAN";
		else $kind = "GEN";

		echo "<?xml version='1.0' encoding='EUC-KR'?>";
		echo "<xml>";
		switch ($type) {
			case "deposit":
				$refund->getPeriodList($kind);
				for ($i = 0; $i < count($refund->periodCode); $i++) {
					echo "<district>";
					echo "<code>" . $refund->periodCode[$i] . "</code>";
					echo "<name>" . htmlspecialchars(stripslashes($refund->periodName[$i])) . "</name>";
					echo "<sdate>" . getEnglishDate($refund->periodSDate[$i]) . "</sdate>";
					echo "<edate>" . getEnglishDate($refund->periodEDate[$i]) . "</edate>";
					echo "</district>";
				}
				break;
		}
		echo "</xml>";

		$refund->closeDatabase();
		unset($refund);
	}
?>