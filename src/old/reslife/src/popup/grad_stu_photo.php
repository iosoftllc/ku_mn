<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../common/popup_header_tpl.php");
		include_once("../common/grad_student_tpl.php");

		$page_title = "지원자 사진 리스트";
		$sub_title = "지원자 사진 리스트";
		$on_load = "";

		$tpl->define_dynamic(list_row, "body");

		$count = 0;
		if ($sort1 == "") $sort = "";
		else $sort = $sort1 . " " . $sort2;
		$student->getStudentList($sdate, $edate, "", "", $s_type, $s_text, $s_kind, $s_nation, $s_current, $sort);
		for ($i = 0; $i < count($student->stuListNumber); $i++) {
			$photo_file = $pht_dir. "/". $student->stuListNumber[$i] . ".jpg";
			if (file_exists($photo_file)) {
				$tpl->assign(array(LIST_NUMBER  => $student->stuListNumber[$i],
				                   LIST_STUDENT => $student->stuListID[$i],
				                   LIST_NAME    => stripslashes($student->stuListLastName[$i].", ".$student->stuListFirstName[$i]),
				                   LIST_GENDER  => $student->getGenderValue($student->stuListGender[$i]),
				                   LIST_PHOTO   => "<img src=\"$photo_file\" width=\"90\">"));
				$tpl->parse(LIST_ROWS, ".list_row");
				$count++;
			}
		}

		$purpose = $_GET["purpose"];
		if ($purpose == "") $purpose = $_POST["purpose"];
		$detail = "총 " . count($student->stuListNumber) . "명의 지원자 사진 리스트 조회 - " . urldecode($purpose);
		$student->insertHistoryWork("S", "Z", $detail);

		$student->closeDatabase();
		unset($student);

		$tpl->assign(array(TOTAL_COUNT => $count));

		include("../common/popup_footer_tpl.php");
	}
?>