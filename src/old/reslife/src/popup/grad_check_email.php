<?
	include_once("../common/popup_header_tpl.php");
	include_once("../common/grad_student_tpl.php");

	$email = $_GET["email"];
	if (!$email) $email = $_POST["email"];

	$page_title = "�̸��� �ߺ� Ȯ�� ���";
	$sub_title = "�̸��� �ߺ� Ȯ�� ���";
	$on_load = "document.CheckEmailForm.email.focus();";

	if ($student->isEmailExist($email)) {
		$use_flag = "0";
		$msg = $email . "(��)�� �̹� ��ϵǾ� �ִ� �̸����Դϴ�.";
	} else if ($email) {
		$use_flag = "1";
		$msg = $email . "(��)�� ����Ͻ� �� �ִ� �̸����Դϴ�.";
	} else {
		$use_flag = "0";
		$msg = "�̸����� �Է��ϼ���.";
	}

	$student->closeDatabase();
	unset($student);

	$tpl->assign(array(EMAIL_VALUE => $email,
	                   MESSAGE     => $msg,
	                   USE_FLAG    => $use_flag));

	include("../common/popup_footer_tpl.php");
?>