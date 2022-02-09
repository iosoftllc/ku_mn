<?
	include_once("../common/popup_header_tpl.php");
	include_once("../common/apply_tpl.php");

	$page_title = "지원자 사진 리스트";
	$sub_title = "지원자 사진 리스트";
	$on_load = "";
/*
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