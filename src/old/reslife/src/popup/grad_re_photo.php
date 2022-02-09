<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../common/popup_header_tpl.php");
		include_once("../common/grad_refund_tpl.php");

		$page_title = "통장 사진 리스트";
		$sub_title = "통장 사진 리스트";
		$on_load = "";

		$tpl->define_dynamic(list_row, "body");

		$count = 0;
		if ($sort1 == "") $sort = "";
		else $sort = $sort1 . " " . $sort2;
		$refund->getRefundList($sdate, $edate, "", "", $s_type, $s_text, $s_kind, $s_new, $s_app, $s_period, $sort);
		for ($i = 0; $i < count($refund->listNumber); $i++) {
			$photo_file = $pht_dir. "/" . $refund->listNumber[$i] . ".jpg";
			if (file_exists($photo_file)) {
				$tpl->assign(array(LIST_NAME  => stripslashes($refund->listName2[$i]).", ".stripslashes($refund->listName1[$i]),
				                   LIST_ROOM  => $refund->listRoom[$i],
				                   LIST_PHOTO => "<img src=\"$photo_file\">"));
				$tpl->parse(LIST_ROWS, ".list_row");
				$count++;
			}
		}

		$purpose = $_GET["purpose"];
		if ($purpose == "") $purpose = $_POST["purpose"];
		$detail = "총 " . count($refund->listNumber) . "개의 과납금 사진 리스트 조회 - " . urldecode($purpose);
		$refund->insertHistoryWork("O", "Z", $detail);

		$refund->closeDatabase();
		unset($refund);

		$tpl->assign(array(TOTAL_COUNT => $count));

		include("../common/popup_footer_tpl.php");
	}
?>