<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/application_tpl.php");
	include_once("../../lib/class.rFastTemplate.php");

	if (isset($_GET["mode"])) $mode = $_GET["mode"];
	else if (isset($_POST["mode"])) $mode = $_POST["mode"];
	else $mode = "";

	$pay_total = $application->getPaymentAmount($no);
	$application->getApplicationInfo($no);
	$email = $application->personEmail;
	$name = $application->personLastName . ", " . $application->personFirstName . " " . $application->personMiddleName;

	$tpl = new rFastTemplate("../../tpl/popup");
	if ($application->applyKind == "L") {
		if ($pay_total > 0 && $application->linkPeriodCode == "2006LS") $tpl->define(array(main => "invoice2_stu.html"));
		else $tpl->define(array(main => "invoice1_stu.html"));
	} else {
		if ($pay_total > 0 && ($application->linkPeriodCode == "2006SA" || $application->linkPeriodCode == "2006SB")) $tpl->define(array(main => "invoice2_stu.html"));
		else $tpl->define(array(main => "invoice_stu.html"));
	}
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

	if ($application->applyKind == "L") {
		$pay_period = "2006.4.3.";
		if ($pay_total > 0 && $application->linkPeriodCode == "2006LS") $pay_period = "2006.4.18. - 2006.4.20.";
	} else {
		$pay_period = "2008.6.10";
		if ($application->linkPeriodCode == "2009WA" || $application->linkPeriodCode == "2009WB") $pay_period = "2008.12.14";
		else if ($application->linkPeriodCode == "2008SA") $pay_period = "2008.2.15";
		else if ($application->linkPeriodCode == "2008MA" || $application->linkPeriodCode == "2008MB") $pay_period = "2008.6.10";
		else if ($application->linkPeriodCode == "2008FA") $pay_period = "2008.7.10";
		else if ($application->linkPeriodCode == "2009SA" || $application->linkPeriodCode == "2009SG") $pay_period = "2009.2.15";
		else if ($application->linkPeriodCode == "2009FA") $pay_period = "2009.7.10";
		else if ($application->linkPeriodCode == "2010WA" || $application->linkPeriodCode == "2010WB") $pay_period = "2009.11.7";
		else if ($application->linkPeriodCode == "2010SG") $pay_period = "2010.1.10";
		else if ($application->linkPeriodCode == "2010MA" || $application->linkPeriodCode == "2010MB") $pay_period = "2010.6.7";
		else if ($application->linkPeriodCode == "2010FA") $pay_period = "2010.7.10";
		else if ($application->linkPeriodCode == "2010ISC") $pay_period = "2010.8.10";
		else if ($application->linkPeriodCode == "2011SA") $pay_period = "2011.1.10";
		else if ($application->linkPeriodCode == "2011MA" || $application->linkPeriodCode == "2011MB") $pay_period = "2011.5.9";
		else if ($application->linkPeriodCode == "2011FA") $pay_period = "2011.7.10";
		else if ($application->linkPeriodCode == "2012SA") $pay_period = "2012.2.19";
		else if ($application->linkPeriodCode == "2012FA") $pay_period = "2012.8.8";
		else if ($application->linkPeriodCode == "2013WA" || $application->linkPeriodCode == "2013WB") $pay_period = "2012.12.7";
		else if ($application->linkPeriodCode == "2013SA") $pay_period = "2013.2.13";
		else if ($application->linkPeriodCode == "2013MA" || $application->linkPeriodCode == "2013MB") $pay_period = "2013.6.8";
		else if ($application->linkPeriodCode == "2013FA") $pay_period = "2013.8.7";
		else if ($application->linkPeriodCode == "2014WA" || $application->linkPeriodCode == "2014WB") $pay_period = "2013.12.6";
		else if ($application->linkPeriodCode == "2014SA") $pay_period = "2014.2.12";
		else if ($application->linkPeriodCode == "2014MA" || $application->linkPeriodCode == "2014MB") $pay_period = "2014.6.9";
		else if ($application->linkPeriodCode == "2014FA") $pay_period = "2014.8.6";
		else if ($application->linkPeriodCode == "2015WA" || $application->linkPeriodCode == "2015WB") $pay_period = "2014.12.5";
		else if ($application->linkPeriodCode == "2015SA") $pay_period = "2015.2.12";
		else if ($application->linkPeriodCode == "2015MA" || $application->linkPeriodCode == "2015MB") $pay_period = "2015.6.5";
		else if ($application->linkPeriodCode == "2015FA") $pay_period = "2015.8.2";
		else if ($application->linkPeriodCode == "2016WA" || $application->linkPeriodCode == "2016WB") $pay_period = "2015.11.29";
		else if ($application->linkPeriodCode == "2016SA") $pay_period = "2016.1.29";
		else if ($application->linkPeriodCode == "2016MA" || $application->linkPeriodCode == "2016MB") $pay_period = "2016.6.5";
		else if ($application->linkPeriodCode == "2016FA") $pay_period = "2016.7.29";
		else if ($application->linkPeriodCode == "2017WA" || $application->linkPeriodCode == "2017WB") $pay_period = "2016.11.18";
		else if ($application->linkPeriodCode == "2017SA") $pay_period = "2017.2.7";
		else if ($application->linkPeriodCode == "2017MA" || $application->linkPeriodCode == "2017MB") $pay_period = "2017.6.4";
		else if ($application->linkPeriodCode == "2017FA") $pay_period = "2017.7.28";
		else if ($application->linkPeriodCode == "2018WA" || $application->linkPeriodCode == "2018WB") $pay_period = "2017.11.18";
		else if ($application->linkPeriodCode == "2018SA") $pay_period = "2018.1.26";
		else if ($application->linkPeriodCode == "2018MA" || $application->linkPeriodCode == "2018MB") $pay_period = "2018.5.26";
		else if ($application->linkPeriodCode == "2018FA") $pay_period = "2018.7.22";
		else if ($application->linkPeriodCode == "2019WA" || $application->linkPeriodCode == "2019WB") $pay_period = "2018.11.23";
		else if ($application->linkPeriodCode == "2019SA") $pay_period = "2019.1.23";
		else if ($application->linkPeriodCode == "2019MA" || $application->linkPeriodCode == "2019MB") $pay_period = "2019.5.29";
		else if ($application->linkPeriodCode == "2019FA") $pay_period = "2019.7.21";
		else if ($application->linkPeriodCode == "2020WA" || $application->linkPeriodCode == "2020WB") $pay_period = "2019.11.23";
		else if ($application->linkPeriodCode == "2020SA") $pay_period = "2020.1.22";
		else if ($application->linkPeriodCode == "2020MA" || $application->linkPeriodCode == "2020MB") $pay_period = "2020.5.23";
		else if ($application->linkPeriodCode == "2020FA") $pay_period = "2020.8.16";
		else if ($application->linkPeriodCode == "2021WA" || $application->linkPeriodCode == "2021WB") $pay_period = "2020.11.27";
		else if ($application->linkPeriodCode == "2021SA" || $application->linkPeriodCode == "2021SB") $pay_period = "2021.01.03";
		else if ($application->linkPeriodCode == "2021SC") $pay_period = "2021.3.22";
		else if ($application->linkPeriodCode == "2021MA" || $application->linkPeriodCode == "2021MB") $pay_period = "2021.5.23";
		else if ($application->linkPeriodCode == "2021FA") $pay_period = "2021.7.18";
		//$pay_period = "2010.8.10";
	}

	$tpl->assign(array(APPLY_NUMBER   => $no,
	                   APPLY_ACCOUNT  => $application->applyAccount,
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
		$from = "reslife@korea.ac.kr";
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