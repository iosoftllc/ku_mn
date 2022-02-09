<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../common/popup_header_tpl.php");
		include_once("../common/application_tpl.php");

		$page_title = "온라인지원 사진 리스트";
		$sub_title = "온라인지원 사진 리스트";
		$on_load = "";

		$tpl->define_dynamic(list_row, "body");

		$count = 0;
		if ($sort1 == "") $sort = "";
		else $sort = $sort1 . " " . $sort2;
		$application->getApplicationList($sdate, $edate, "", "", $s_type, $s_text, $s_rate, $s_state, $s_grade, $s_kind, $s_current, $s_period, $sort);
		for ($i = 0; $i < count($application->listNumber); $i++) {
			if ($application->listState[$i] != "CC" && $application->listState[$i] != "CR" && $application->listState[$i] != "CA" && trim($application->listRoomCode[$i])) $flag = true;
			else $flag = false;
			$photo_file = $pht_dir. "/". $application->listStudentNo[$i] . ".jpg";
			if ($flag) {
				if (file_exists($photo_file)) $photo = "<img src=\"$photo_file\" width=\"90\">";
				else $photo = "";
				$tpl->assign(array(LIST_NUMBER  => $application->listNumber[$i],
				                   LIST_STUDENT => $application->listStudentID[$i],
				                   LIST_NAME    => stripslashes($application->listLastName[$i]).", ".stripslashes($application->listFirstName[$i]),
				                   LIST_GENDER  => $application->getGenderValue($application->listGender[$i]),
				                   LIST_ROOM    => $application->listRoomCode[$i],
				                   LIST_PHOTO   => $photo));
				$tpl->parse(LIST_ROWS, ".list_row");
				$count++;
			}
		}

		$purpose = $_GET["purpose"];
		if ($purpose == "") $purpose = $_POST["purpose"];
		$detail = "총 " . count($application->listNumber) . "개의 온라인지원 사진 조회 - " . urldecode($purpose);
		$application->insertHistoryWork("A", "Z", $detail);

		$application->closeDatabase();
		unset($application);

		$tpl->assign(array(TOTAL_COUNT => $count));

		include("../common/popup_footer_tpl.php");
	}
?>