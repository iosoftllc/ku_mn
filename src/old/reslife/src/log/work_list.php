<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../common/work_tpl.php");
		include_once("../common/header_tpl.php");

		$page_name .= " ¸®½ºÆ®";

		$tpl->define_dynamic(array("page_row"  => "body",
		                           "list_row"  => "body",
		                           "year_row"  => "body",
		                           "month_row" => "body",
		                           "admin_row" => "body"));

		$begin_yr = 2019;
		$end_yr = date("Y");
		for ($i = $begin_yr; $i <= $end_yr; $i++) {
			$tpl->assign("YEAR_VALUE", $i);
			$tpl->parse("YEAR_ROWS", ".year_row");
		}
		for ($i = 1; $i <= 12; $i++) {
			$temp = $i;
			if ($temp < 10) $temp = "0" . $temp;
			$tpl->assign("MONTH_VALUE", $temp);
			$tpl->parse("MONTH_ROWS", ".month_row");
		}

		$historyWork->getAdminList("");
		for ($i = 0; $i < count($historyWork->adminListID); $i++) {
			$tpl->assign(array("ADMIN_ID"   => $historyWork->adminListID[$i],
			                   "ADMIN_NAME" => stripslashes($historyWork->adminListName[$i])));
			$tpl->parse("ADMIN_ROWS", ".admin_row");
		}

		$list_no = 20;
		$all_count = $historyWork->getWorkCount($s_admin, $s_building, $s_menu, $s_kind, $sdate, $edate, $s_type, $s_text);
		$total_page = getTotalPage($all_count, $list_no);
		$page = getCurrentPage($page, $total_page);
		$offset = getOffset($page, $list_no);
		$next_page = getNextPage($page);
		$pre_page = getPrePage($next_page);
		if ($page != 0) {
			for ($i = (int)$next_page-10; $i <= (int)$next_page-1; $i++) {
				if ($i == $page) $page_value = "&nbsp;<b>" . $i . "</b>&nbsp;";
				else $page_value = "&nbsp;<a href=\"javascript:gotoPage(document.ListForm, '" . $i . "');\">" . $i . "</a>&nbsp;";
				$tpl->assign("PAGE_VALUE", $page_value);
				$tpl->parse("PAGE_ROWS", ".page_row");
				if ($i == $total_page) break;
			}
		}
		if ((int)$next_page > $total_page) $next_page = "";
		$tpl->assign(array("SEL_PAGE"        => $page,
		                   "SEARCH_TYPE"     => $s_type,
		                   "SEARCH_TEXT"     => $s_text,
		                   "SEARCH_ADMIN"    => $s_admin,
		                   "SEARCH_BUILDING" => $s_building,
		                   "SEARCH_MENU"     => $s_menu,
		                   "SEARCH_KIND"     => $s_kind,
		                   "SEARCH_YEAR1"    => $s_yy1,
		                   "SEARCH_MONTH1"   => $s_mm1,
		                   "SEARCH_DAY1"     => $s_dd1,
		                   "SEARCH_YEAR2"    => $s_yy2,
		                   "SEARCH_MONTH2"   => $s_mm2,
		                   "SEARCH_DAY2"     => $s_dd2,
		                   "SORT1_VALUE"     => $sort1,
		                   "SORT2_VALUE"     => $sort2,
		                   "PRE_PAGE"        => $pre_page,
		                   "NEXT_PAGE"       => $next_page,
		                   "TOTAL_PAGE"      => $total_page,
		                   "TOTAL_COUNT"     => $all_count));

		if (trim($sort1) != "") $sort = $sort1 . " " . $sort2;
		else $sort = "";
		$historyWork->getWorkList($offset, $list_no, $s_admin, $s_building, $s_menu, $s_kind, $sdate, $edate, $s_type, $s_text, $sort);
		for ($i = 0; $i < count($historyWork->workListNumber); $i++) {
			$tpl->assign(array("LIST_NUMBER"     => $historyWork->workListNumber[$i],
			                   "LIST_TIME"       => $historyWork->workListTime[$i],
			                   "LIST_ID"         => $historyWork->workListID[$i],
			                   "LIST_NAME"       => stripslashes($historyWork->workListName[$i]),
			                   "LIST_DEPARTMENT" => stripslashes($historyWork->workListDepartment[$i]),
			                   "LIST_IP"         => $historyWork->workListIP[$i],
			                   "LIST_BUILDING"   => $historyWork->getWorkBuildingValue($historyWork->workListBuilding[$i]),
			                   "LIST_MENU"       => $historyWork->getWorkMenuValue($historyWork->workListMenu[$i]),
			                   "LIST_KIND"       => $historyWork->getWorkKindValue($historyWork->workListKind[$i]),
			                   "LIST_DETAIL"     => stripslashes($historyWork->workListDetail[$i])));
			$tpl->parse("LIST_ROWS", ".list_row");
		}

		$historyWork->closeDatabase();
		unset($historyWork);

		include_once("../common/footer_tpl.php");
	}
?>