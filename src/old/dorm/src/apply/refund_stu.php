<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/application_tpl.php");

	$application->getApplicationInfo($no);
	if (!$application->applyNumber) {
		$application->closeDatabase();
		unset($application);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"There is not correspondant application.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	//} else if (!($application->applyState == "DP" || $application->applyState == "DD" || $application->applyState == "FP" || $application->applyState == "FD") && $application->isRefundExist($no)) {
	} else if ($application->isRefundExist($no)) {
		$application->closeDatabase();
		unset($application);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"You already requested a refund.\");";
		echo "history.go(-1);";
		echo "</script>";
	//} else if ($application->applyState == "RR" || $application->applyState == "TR" || $application->applyState == "RD" || $application->applyState == "CF") {
	//} else if ($email != "webmaster@intia.co.kr" && (int)$application->getDepositPaidAmount($no) <= 0) {
	} else if ((int)$application->getDepositPaidAmount($no) <= 0) {
		$application->closeDatabase();
		unset($application);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Sorry, your Deposit Refund/Transfer Request is not available.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else {
		$html_dir = "apply";
		$html_file = "refund_stu";
		$on_load = "";
		include_once("../../src/common/tpl_header.php");

		$tpl->define_dynamic(array(year_row     => "body",
		                           month_row    => "body",
		                           cf_apply_row => "body"));

		for ($i = date("Y") - 1; $i <= date("Y") + 1; $i++) {
			$tpl->assign(YEAR_VALUE, $i);
			$tpl->parse(YEAR_ROWS, ".year_row");
		}
		for ($i = 1; $i <= 12; $i++) {
			$temp = $i;
			if ($temp < 10) $temp = "0" . $temp;
			$tpl->assign(MONTH_VALUE, $temp);
			$tpl->parse(MONTH_ROWS, ".month_row");
		}

		$application->getPeriodList1($no, $application->personEmail, $application->linkPeriodEDate);
		for ($i = 0; $i < count($application->appListNumber); $i++) {
			$tpl->assign(array(CF_APPLY_NUMBER => $application->appListNumber[$i],
			                   CF_APPLY_PERIOD => $application->appListNumber[$i]));
			                   //CF_APPLY_PERIOD => $application->appListNumber[$i] . " - " . stripslashes($application->appListPeriodName[$i])));
			$tpl->parse(CF_APPLY_ROWS, ".cf_apply_row");
		}

		$tpl->assign(array(APPLY_NUMBER     => $no,
		                   STUDENT_EMAIL    => $email,
		                   STUDENT_PASSWORD => $pw));

		include("../common/tpl_variables.php");

		$application->closeDatabase();
		unset($application);

		include_once("../../src/common/tpl_footer.php");
		include_once("../../src/common/counter_tpl.php");
	}
?>