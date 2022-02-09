<?
	include_once("../../lib/conf.common.php");
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.cRefund.php");

	$type = $_POST["type"];
	$kind = $_POST["kind"];
	if ($type == "") $type = $_GET["type"];
	if ($kind == "") $kind = $_GET["kind"];
	if ($kind == "L") $kind = "LAN";
	else $kind = "GEN";

	$refund = new cRefund($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $refundTable, $periodTable, $applicantTable);
	$refund->connectDatabase();

	echo "<?xml version='1.0' encoding='EUC-KR'?>";
	echo "<xml>";
	switch ($type) {
		case "deposit":
			$refund->getPeriodList($kind);
			for ($i = 0; $i < count($refund->periodCode); $i++) {
				echo "<district>";
				echo "<code>" . $refund->periodCode[$i] . "</code>";
				echo "<old>" . $refund->periodOld[$i] . "</old>";
				echo "<new>" . $refund->periodNew[$i] . "</new>";
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
?>