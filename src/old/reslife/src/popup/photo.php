<?
	include_once("../common/popup_header_tpl.php");
	include_once("../common/apply_tpl.php");

	$page_title = "������ ���� ����Ʈ";
	$sub_title = "������ ���� ����Ʈ";
	$on_load = "";
/*
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
*/
	$tpl->define_dynamic(list_row, "body");

	$count = 0;
	if ($sort1 == "") $sort = "";
	else $sort = $sort1 . " " . $sort2;
	$applicant->getApplicantList($sdate, $edate, "", "", $s_type, $s_text, $s_state, $s_kind, $s_current, $s_period, $sort);
	for ($i = 0; $i < count($applicant->listNumber); $i++) {
		$photo_file = $pht_dir. "/". $applicant->listNumber[$i] . ".jpg";
		if (file_exists($photo_file)) {
			$tpl->assign(array(LIST_NUMBER  => $applicant->listNumber[$i],
			                   LIST_STUDENT => $applicant->listStudentID[$i],
			                   LIST_NAME    => stripslashes($applicant->listLastName[$i]).", ".stripslashes($applicant->listFirstName[$i]),
			                   LIST_GENDER  => $applicant->getGenderValue($applicant->listGender[$i]),
			                   LIST_ROOM    => $applicant->listRoomCode[$i],
			                   LIST_PHOTO   => "<img src=\"$photo_file\" width=\"90\">"));
			$tpl->parse(LIST_ROWS, ".list_row");
			$count++;
		}
	}

	$applicant->closeDatabase();
	unset($applicant);

	$tpl->assign(array(TOTAL_COUNT => $count));

	include("../common/popup_footer_tpl.php");
?>