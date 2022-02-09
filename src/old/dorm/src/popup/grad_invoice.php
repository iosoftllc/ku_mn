<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/grad_application_tpl.php");
	include_once("../../lib/class.rFastTemplate.php");

	if (isset($_GET["mode"])) $mode = $_GET["mode"];
	else if (isset($_POST["mode"])) $mode = $_POST["mode"];
	else $mode = "";

	$pay_total = $application->getPaymentAmount($no);
	$application->getApplicationInfo($no);
	$email = $application->personEmail;
	$name = $application->personLastName . ", " . $application->personFirstName . " " . $application->personMiddleName;

	$tpl = new rFastTemplate("../../tpl/popup");
	$tpl->define(array(main => "grad_invoice.html"));
	$tpl->define_dynamic(array(payment1_row => "main",
	                           payment2_row => "main",
	                           email_row    => "main"));

	$pay_total = 0;
	$application->getPaymentList($no);
	for ($i = 0; $i < count($application->payListNumber); $i++) {
		$pay_total += (int)$application->payListPrice[$i];
		$tpl->assign(array(PAYMENT1_DATE   => substr($application->payListDate[$i], 0, 10),
		                   PAYMENT1_PRICE  => number_format($application->payListPrice[$i]),
		                   PAYMENT1_DETAIL => $application->getDetailValue($application->payListDetail[$i])));
		$tpl->parse(PAYMENT1_ROWS, ".payment1_row");
		$tpl->assign(array(PAYMENT2_DATE   => substr($application->payListDate[$i], 0, 10),
		                   PAYMENT2_PRICE  => number_format($application->payListPrice[$i]),
		                   PAYMENT2_DETAIL => $application->getDetailValue($application->payListDetail[$i])));
		$tpl->parse(PAYMENT2_ROWS, ".payment2_row");
	}

	$pay_period = "2019.7.26 ~ 2019.8.9";
	if ($application->linkPeriodCode == "201926" || $application->linkPeriodCode == "201924") $pay_period = "2019.7.26 ~ 2019.8.9";
	else if ($application->linkPeriodCode == "202016" || $application->linkPeriodCode == "202014") $pay_period = "2020.1.21 ~ 2020.2.7";
	else if ($application->linkPeriodCode == "202026" || $application->linkPeriodCode == "202024") $pay_period = "2020.8.14 ~ 2020.8.15";
	else if ($application->linkPeriodCode == "202116" || $application->linkPeriodCode == "202114") $pay_period = "2020.12.29 ~ 2021.01.15";
	else if ($application->linkPeriodCode == "2021SQ") $pay_period = "2020.06.20";
	else if ($application->linkPeriodCode == "202126" || $application->linkPeriodCode == "202124") $pay_period = "2021.08.13";

	$acc_no = "391-910012-18304";
	if (trim($application->applyAccount)) $acc_no = trim($application->applyAccount);

	$tpl->assign(array(APPLY_NUMBER   => $no,
	                   APPLY_ACCOUNT  => $acc_no,
	                   APPLY_STUDENT  => $application->personStudentID,
	                   APPLY_NAME     => stripslashes($name),
	                   APPLY_ROOM     => stripslashes($application->linkRoomCode),
	                   APPLY_TOTAL    => number_format($pay_total),
	                   PAYMENT_PERIOD => $pay_period));

	$application->closeDatabase();
	unset($application);

	if ($mode == "email") {
		$tpl->parse(FINAL, "main");
		$msg = $tpl->GetTemplate(FINAL);
		$from = "boramham@korea.ac.kr";
		$subject = "[KU Residence Life] INVOICE";
		$flag = sendEmail($email, $from, $subject, $msg);
		if ($flag) {
			echo "<script langauage=\"javascript\">";
			echo "alert(\"메일을 성공적으로 보냈습니다.\");";
			echo "self.close();";
			echo "</script>";
		} else {
			echo "<script langauage=\"javascript\">";
			echo "alert(\"작업수행 중 오류가 발생하였습니다.\\n\\n나중에 다시 시도해 주세요.\");";
			echo "history.go(-1);";
			echo "</script>";
		}
	} else {
		$tpl->parse(EMAIL_ROWS, ".email_row");
		$tpl->parse(FINAL, "main");
		$tpl->FastPrint(FINAL);
	}
?>