<?
	include_once("../common/popup_header_tpl.php");
	include_once("../common/admin_tpl.php");

	$page_title = "아이디 중복 확인 결과";
	$sub_title = "아이디 중복 확인 결과";
	$on_load = "document.CheckIDForm.id.focus();";

	if ($admin->isExist($id)) {
		$use_flag = "0";
		$msg = $id . "(은)는 이미 등록되어 있는 아이디입니다.";
	} else if ($id) {
		$use_flag = "1";
		$msg = $id . "(은)는 사용하실 수 있는 아이디입니다.";
	} else {
		$use_flag = "0";
		$msg = "아이디를 입력하세요.";
	}

	$admin->closeDatabase();
	unset($admin);

	$tpl->assign(array(ADMIN_ID => $id,
	                   MESSAGE  => $msg,
	                   USE_FLAG => $use_flag));

	include("../common/popup_footer_tpl.php");
?>