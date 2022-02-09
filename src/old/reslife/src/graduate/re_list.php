<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 6 || (int)$ihouse_admin_info[grade] == 7 || (int)$ihouse_admin_info[grade] == 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/grad_refund_tpl.php");

			$page_name .= " 리스트";

			include_once("../common/header_tpl.php");

			$tpl->define_dynamic(array(page_row   => "body",
			                           list_row   => "body",
			                           year_row   => "body",
			                           month_row  => "body",
			                           period_row => "body"));

			$begin_yr = 2005;
			$end_yr = date("Y");
			for ($i = $begin_yr; $i <= $end_yr; $i++) {
				$tpl->assign(YEAR_VALUE, $i);
				$tpl->parse(YEAR_ROWS, ".year_row");
			}
			for ($i = 1; $i <= 12; $i++) {
				$temp = $i;
				if ($temp < 10) $temp = "0" . $temp;
				$tpl->assign(MONTH_VALUE, $temp);
				$tpl->parse(MONTH_ROWS, ".month_row");
			}

			$refund->getPeriodList();
			for ($i = 0; $i < count($refund->periodCode); $i++) {
				$tpl->assign(array(PERIOD_CODE => $refund->periodCode[$i],
				                   PERIOD_NAME => stripslashes($refund->periodName[$i])));
				$tpl->parse(PERIOD_ROWS, ".period_row");
			}

			$list_no = 20;
			$all_count = $refund->getRefundCount($sdate, $edate, $s_type, $s_text, $s_kind, $s_new, $s_app, $s_period);
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
			$tpl->assign(array(SEL_PAGE       => $page,
			                   SEARCH_TYPE    => $s_type,
			                   SEARCH_TEXT    => $s_text,
			                   SEARCH_APPROVE => $s_app,
			                   SEARCH_KIND    => $s_kind,
			                   SEARCH_NEW     => $s_new,
			                   SEARCH_PERIOD  => $s_period,
			                   SEARCH_YEAR1   => $s_year1,
			                   SEARCH_MONTH1  => $s_month1,
			                   SEARCH_DAY1    => $s_day1,
			                   SEARCH_YEAR2   => $s_year2,
			                   SEARCH_MONTH2  => $s_month2,
			                   SEARCH_DAY2    => $s_day2,
			                   SORT1_VALUE    => $sort1,
			                   SORT2_VALUE    => $sort2,
			                   PRE_PAGE       => $pre_page,
			                   NEXT_PAGE      => $next_page,
			                   TOTAL_PAGE     => $total_page,
			                   TOTAL_COUNT    => $all_count,
			                   TODAY_YEAR     => date("Y"),
			                   TODAY_MONTH    => date("m"),
			                   TODAY_DAY      => date("d")));

			$detail = "";
			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$refund->getRefundList($sdate, $edate, $offset, $list_no, $s_type, $s_text, $s_kind, $s_new, $s_app, $s_period, $sort);
			for ($i = 0; $i < count($refund->listNumber); $i++) {
				$detail .= $refund->listApply[$i] . ", ";
				$paid = $refund->getDepositPaid($refund->listApply[$i]);
				$overpay = $refund->getOverpayment($refund->listApply[$i]);
				$total = abs($paid + $overpay);
				$payment = $total - (int)$refund->listDeduction[$i];
				if (substr($refund->listEdit[$i], 0, 10) == "0000-00-00") $edit_dt = "";
				else $edit_dt = substr($refund->listEdit[$i], 0, 10);
				if (substr($refund->listAppDate[$i], 0, 10) == "0000-00-00") $app_dt = "";
				else $app_dt = substr($refund->listAppDate[$i], 0, 10);
				if ($refund->listApply[$i]) $apply_no = $refund->listApply[$i];
				else $apply_no = "";
				$tpl->assign(array(LIST_NUMBER     => $refund->listNumber[$i],
				                   LIST_APPLY      => $apply_no,
				                   LIST_APPROVE    => $refund->getApproveValue($refund->listApprove[$i]),
				                   LIST_KIND       => $refund->getKindValue($refund->listKind[$i]),
				                   LIST_REFUND     => $refund->getRefundValue1($refund->listNew[$i], $refund->listPayMethod[$i]),
				                   LIST_STUDENT_NO => $refund->listStudentNo[$i],
				                   LIST_STUDENT_ID => $refund->listStudent[$i],
				                   LIST_NAME       => stripslashes($refund->listName2[$i]).", ".stripslashes($refund->listName1[$i]),
				                   LIST_EMAIL      => $refund->listEmail[$i],
				                   LIST_PAYMENT    => $payment,
				                   LIST_EDIT       => $edit_dt,
				                   LIST_APP_DATE   => $app_dt,
				                   LIST_DATE       => substr($refund->listDate[$i], 0, 10),
				                   LIST_PERIOD     => stripslashes($refund->listPeriod[$i]),
				                   LIST_ROOM       => $refund->listRoom[$i],
				                   LIST_PHOTO      => getListImage($pht_dir."/".$refund->listNumber[$i].".jpg")));
				$tpl->parse(LIST_ROWS, ".list_row");
			}

			if ($detail != "") $detail = substr($detail, 0, -2) . " 지원번호 과납금 정보 조회";
			$refund->insertHistoryWork("O", "L", $detail);

			$refund->closeDatabase();
			unset($refund);

			include_once("../common/footer_tpl.php");
		}
	}
?>