<?
	include_once("../common/popup_header_tpl.php");
	include_once("../common/admin_tpl.php");

	$page_title = "���̵� �ߺ� Ȯ�� ���";
	$sub_title = "���̵� �ߺ� Ȯ�� ���";
	$on_load = "document.CheckIDForm.id.focus();";

	if ($admin->isExist($id)) {
		$use_flag = "0";
		$msg = $id . "(��)�� �̹� ��ϵǾ� �ִ� ���̵��Դϴ�.";
	} else if ($id) {
		$use_flag = "1";
		$msg = $id . "(��)�� ����Ͻ� �� �ִ� ���̵��Դϴ�.";
	} else {
		$use_flag = "0";
		$msg = "���̵� �Է��ϼ���.";
	}

	$admin->closeDatabase();
	unset($admin);

	$tpl->assign(array(ADMIN_ID => $id,
	                   MESSAGE  => $msg,
	                   USE_FLAG => $use_flag));

	include("../common/popup_footer_tpl.php");
?>