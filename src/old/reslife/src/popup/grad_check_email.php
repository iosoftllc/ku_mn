<?
	include_once("../common/popup_header_tpl.php");
	include_once("../common/grad_student_tpl.php");

	$email = $_GET["email"];
	if (!$email) $email = $_POST["email"];

	$page_title = "이메일 중복 확인 결과";
	$sub_title = "이메일 중복 확인 결과";
	$on_load = "document.CheckEmailForm.email.focus();";

	if ($student->isEmailExist($email)) {
		$use_flag = "0";
		$msg = $email . "(은)는 이미 등록되어 있는 이메일입니다.";
	} else if ($email) {
		$use_flag = "1";
		$msg = $email . "(은)는 사용하실 수 있는 이메일입니다.";
	} else {
		$use_flag = "0";
		$msg = "이메일을 입력하세요.";
	}

	$student->closeDatabase();
	unset($student);

	$tpl->assign(array(EMAIL_VALUE => $email,
	                   MESSAGE     => $msg,
	                   USE_FLAG    => $use_flag));

	include("../common/popup_footer_tpl.php");
?>