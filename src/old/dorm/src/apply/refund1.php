<?
	include_once("../../lib/func.common.php");
	include_once("../../lib/conf.common.php");
	include_once("../../lib/class.cRefund.php");

	$no = $_GET["no"];
	if (!$no) $no = $_POST["no"];

	$refund = new cRefund($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $refundTable, $periodTable, $applicantTable);
	$refund->connectDatabase();
	$refund->rateTableName = $rateTable;
	$refund->getApplicantInfo($no);
	if (!$refund->applyNumber) {
		$refund->closeDatabase();
		unset($refund);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"There is not correspondant application.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($refund->applyState != "FD" && $refund->isRefundExist($no)) {
		$refund->closeDatabase();
		unset($refund);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"You already requested a refund.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($refund->applyState == "DP" || $refund->applyState == "FP" || $refund->applyState == "RR" || $refund->applyState == "TR" || $refund->applyState == "RD" || $refund->applyState == "CF") {
		$refund->closeDatabase();
		unset($refund);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Sorry, your Deposit Refund/Transfer Request is not available.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else {
		$html_dir = "apply";
		$html_file = "refund1";
		$on_load = "document.location.href='#';";

		include_once("../../src/common/tpl_header.php");

		$tpl->define_dynamic(array(year_row     => "body",
		                           month_row    => "body",
		                           cf_apply_row => "body"));

		for ($i = 1950; $i <= date("Y"); $i++) {
			$tpl->assign(YEAR_VALUE, $i);
			$tpl->parse(YEAR_ROWS, ".year_row");
		}
		for ($i = 1; $i <= 12; $i++) {
			$temp = $i;
			if ($temp < 10) $temp = "0" . $temp;
			$tpl->assign(MONTH_VALUE, $temp);
			$tpl->parse(MONTH_ROWS, ".month_row");
		}

		$refund->getPeriodList($no, $refund->applyStudent, $refund->applyEndDate);
		for ($i = 0; $i < count($refund->appListNumber); $i++) {
			$tpl->assign(array(CF_APPLY_NUMBER => $refund->appListNumber[$i],
			                   CF_APPLY_PERIOD => $refund->appListNumber[$i]));
			                   //CF_APPLY_PERIOD => $refund->appListNumber[$i] . " - " . stripslashes($refund->appListPeriod[$i])));
			$tpl->parse(CF_APPLY_ROWS, ".cf_apply_row");
		}

		$tpl->assign(array(APPLY_NUMBER      => $no));

		$refund->closeDatabase();
		unset($refund);

		include_once("../../src/common/tpl_footer.php");
		include_once("../../src/common/counter_tpl.php");
	}
?>