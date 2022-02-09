<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/grad_application_tpl.php");

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
	/*} else if ((int)$application->getDepositPaidAmount($no) <= 0) {
		$application->closeDatabase();
		unset($application);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Sorry, your Deposit Refund/Transfer Request is not available.\");";
		echo "history.go(-1);";
		echo "</script>";*/
	} else {
		$html_dir = "graduate";
		$html_file = "refund";
		$on_load = "";
		$main_menu_index = 4;
		$page_menu_index = 10;
		$etc_menu_index = 0;
		include_once("../../src/common/tpl_header.php");

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