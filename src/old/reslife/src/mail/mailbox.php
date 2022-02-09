<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 3) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/header_tpl.php");
			include_once("../../lib/func.common.php");
			include_once("../../lib/class.cMailbox.php");

			$main_index = 0;
			$sub_index = 2;
			$page_name = "";
			$on_load = "";

			$page = $_GET["page"];
			$s_type = $_GET["s_type"];
			$s_text = $_GET["s_text"];
			$sort1 = $_GET["sort1"];
			$sort2 = $_GET["sort2"];
			if (!$page) $page = $_POST["page"];
			if (!$s_type) $s_type = $_POST["s_type"];
			if (!$s_text) $s_text = $_POST["s_text"];
			if (!$sort1) $sort1 = $_POST["sort1"];
			if (!$sort2) $sort2 = $_POST["sort2"];

			$mailbox = new cMailbox($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $mailboxTable, $applicantTable);
			$mailbox->connectDatabase();

			$tpl->define_dynamic(array(page_row => "body",
			                           mail_row => "body"));
	
			$list_no = 20;
			$all_count = $mailbox->getMailCount($s_type, $s_text);
			$total_page = getTotalPage($all_count, $list_no);
			$page = getCurrentPage($page, $total_page);
			$offset = getOffset($page, $list_no);
			$next_page = getNextPage($page);
			$pre_page = getPrePage($next_page);
			if ($page != 0) {
				for ($i = (int)$next_page-10; $i <= (int)$next_page-1; $i++) {
					if ($i == $page) $page_value = "&nbsp;<b>" . $i . "</b>&nbsp;";
					else $page_value = "&nbsp;<a href=\"javascript:gotoPage('" . $i . "');\">" . $i . "</a>&nbsp;";
					$tpl->assign(PAGE_VALUE, $page_value);
					$tpl->parse(PAGE_ROWS, ".page_row");
					if ($i == $total_page) break;
				}
			}
			if ((int)$next_page > $total_page) $next_page = "";
			$tpl->assign(array(SEL_PAGE    => $page,
			                   SEARCH_TYPE => $s_type,
			                   SEARCH_TEXT => $s_text,
			                   SORT1_VALUE => $sort1,
			                   SORT2_VALUE => $sort2,
			                   PRE_PAGE    => $pre_page,
			                   NEXT_PAGE   => $next_page,
			                   TOTAL_PAGE  => $total_page,
			                   TOTAL_COUNT => $all_count));
	
			if (!$sort1) $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$mailbox->getMailList($offset, $list_no, $s_type, $s_text, $sort);
			for ($i = 0; $i < count($mailbox->listNumber); $i++) {
				$subject = stripslashes($mailbox->listSubject[$i]);
				$subject = htmlspecialchars($subject);
				$imt_file = "";
				if (file_exists("../../../upload/mail/".$mailbox->listNumber[$i].".jpg")) {
					$img_size = getimagesize("../../images/main/icon_img.jpg");
					$img_width = $img_size[0];
					$img_height = $img_size[1];
					$imt_file = "<a href=\"javascript:previewImage('../../../upload/mail/".$mailbox->listNumber[$i].".jpg')\"><img src=\"../../images/main/icon_img.jpg\" width=\"$img_width\" height=\"$img_height\" border=\"0\"></a>";
				}
				$tpl->assign(array(MAIL_NUMBER   => $mailbox->listNumber[$i],
				                   MAIL_SUBJECT  => $subject,
				                   MAIL_RECEIVER => htmlspecialchars($mailbox->listReceiver[$i]),
				                   MAIL_DATE     => $mailbox->listDate[$i],
				                   IMAGE_FILE    => $imt_file));
				$tpl->parse(MAIL_ROWS, ".mail_row");
			}
	
			$mailbox->closeDatabase();
			unset($mailbox);

			include_once("../common/footer_tpl.php");
		}
	}
?>