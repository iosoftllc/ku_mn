<?
	include_once("../../lib/conf.common.php");
	include_once("../../lib/func.common.php");
	include_once("../../lib/class.GraduateRefund.php");

	$type = $_POST["type"];
	if ($type == "") $type = $_GET["type"];

	$refund = new GraduateRefund($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $graduateRefundTable, $graduatePeriodTable, $graduateApplicantTable);
	$refund->connectDatabase();

	echo "<?xml version='1.0' encoding='EUC-KR'?>";
	echo "<xml>";
	switch ($type) {
		case "deposit":
			$refund->getPeriodList();
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