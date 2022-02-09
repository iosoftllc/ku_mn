<?
	include_once("../common/popup_header_tpl.php");
	include_once("../common/defer_tpl.php");

	$apply_no = $_GET["apply_no"];
	if (!$apply_no) $apply_no = $_POST["apply_no"];

	$page_title = "������ ���� Ȯ�� ���";
	$sub_title = "������ ���� Ȯ�� ���";
	$on_load = "document.CheckStudentForm.apply_no.focus();";

	$email = "";
	$name = "";
	$student = "";
	$address = "";
	$degree = "";
	$period = "";
	$amount = 0;
	$pay_dt = "";
	if ($defer->isApplicationExist1($apply_no)) {
		$use_flag = "1";
		$msg = $apply_no . "(��)�� ��ϵǾ� �ִ� ������ȣ�Դϴ�.";
		$email = $defer->studentEmail;
		$defer->getStudentInfo1($email);
		$name = stripslashes($defer->studentLastName . ", " . $defer->studentFirstName . " " . $defer->studentMiddleName);
		$student = $defer->studentID;
		$address = getAddressValue($defer->studentAddress, $defer->studentAddr1, $defer->studentAddr2, $defer->studentAddrCity, $defer->studentAddrState, $defer->studentAddrCountry, $defer->studentAddrPostal);
		$degree = $defer->getClassValue($defer->studentClass);
		$period = $defer->getPeriodName($apply_no);
		$amount = $defer->getPaidAmount($apply_no);
		$pay_dt = $defer->getPaidDate($apply_no);
	} else if ($apply_no) {
		$use_flag = "0";
		$msg = $apply_no . "(��)�� ��ϵǾ� ���� ���� ������ȣ�Դϴ�.";
	} else {
		$use_flag = "0";
		$msg = "������ȣ�� �Է��ϼ���.";
	}

	$tpl->assign(array(APPLY_NUMBER  => $apply_no,
	                   MESSAGE       => $msg,
	                   USE_FLAG      => $use_flag,
	                   INFO_EMAIL    => $email,
	                   INFO_NAME     => $name,
	                   INFO_STUDENT  => $student,
	                   INFO_ADDRESS  => $address,
	                   INFO_DEGREE   => $degree,
	                   INFO_PERIOD   => $period,
	                   INFO_AMOUNT   => number_format($amount),
	                   INFO_PAY_DATE => $pay_dt));

	$defer->closeDatabase();
	unset($defer);

	include("../common/popup_footer_tpl.php");
?>