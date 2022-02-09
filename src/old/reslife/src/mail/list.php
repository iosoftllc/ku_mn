<?
	include_once("../common/login_tpl.php");

	$main_index = 0;
	$sub_index = 0;
	$on_load = "";
	$page_name = "관리자";

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 9) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/admin_tpl.php");
			include_once("../common/header_tpl.php");

			$page_name .= " 리스트";

			$tpl->define_dynamic(array(page_row => "body",
			                           list_row => "body"));

			$list_no = 20;
			$all_count = $admin->getAdminCount($s_type, $s_text, $s_grade);
			$total_page = getTotalPage($all_count, $list_no);
			$page = getCurrentPage($page, $total_page);
			$offset = getOffset($page, $list_no);
			$next_page = getNextPage($page);
			$pre_page = getPrePage($next_page);
			if ($page != 0) {
				for ($i = (int)$next_page-10; $i <= (int)$next_page-1; $i++) {
					if ($i == $page) $page_value = "&nbsp;<b>" . $i . "</b>&nbsp;";
					else $page_value = "&nbsp;<a href=\"javascript:gotoPage(document.AdminForm, '" . $i . "');\">" . $i . "</a>&nbsp;";
					$tpl->assign(PAGE_VALUE, $page_value);
					$tpl->parse(PAGE_ROWS, ".page_row");
					if ($i == $total_page) break;
				}
			}
			if ((int)$next_page > $total_page) $next_page = "";
			$tpl->assign(array(SEL_PAGE     => $page,
			                   SEARCH_TYPE  => $s_type,
			                   SEARCH_TEXT  => $s_text,
			                   SEARCH_GRADE => $s_grade,
			                   SORT1_VALUE  => $sort1,
			                   SORT2_VALUE  => $sort2,
			                   PRE_PAGE     => $pre_page,
			                   NEXT_PAGE    => $next_page,
			                   TOTAL_PAGE   => $total_page,
			                   TOTAL_COUNT  => $all_count));

			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$admin->getAdminList($offset, $list_no, $s_type, $s_text, $s_grade, $sort);
			for ($i = 0; $i < count($admin->listID); $i++) {
				$tpl->assign(array(LIST_ID         => $admin->listID[$i],
				                   LIST_GRADE      => getMemberGrade($admin->listGrade[$i]),
				                   LIST_NAME       => stripslashes($admin->listName[$i]),
				                   LIST_DEPARTMENT => stripslashes($admin->listDepartment[$i]),
				                   LIST_EMAIL      => $admin->listEmail[$i],
				                   LIST_COUNT      => number_format($admin->listCount[$i]),
				                   LIST_DATE       => substr($admin->listDate[$i], 0, 10)));
				$tpl->parse(LIST_ROWS, ".list_row");
			}

			$admin->closeDatabase();
			unset($admin);

			include_once("../common/footer_tpl.php");
		}
	}
?>