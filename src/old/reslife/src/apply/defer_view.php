<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 7 && (int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/defer_tpl.php");

			$page_name .= " 상세정보 보기";

			include_once("../common/header_tpl.php");

			$defer->getDeferInfo($no);
			$degree1 = $degree2 = $degree3 = $exchange1 = $exchange2 = $exchange3 = "(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)";
			if ($defer->deferClass == "P" || $defer->deferClass == "J" || $defer->deferClass == "S") $degree1 = "( 0 )";
			else if ($defer->deferClass == "M") $degree2 = "( 0 )";
			else if ($defer->deferClass == "D") $degree3 = "( 0 )";
			if ($defer->deferExchange == "KUSEP") $exchange1 = "( 0 )";
			else if ($defer->deferExchange == "KIEP") $exchange2 = "( 0 )";
			else if ($defer->deferExchange == "ISEP") $exchange3 = "( 0 )";

			$tpl->assign(array(SEL_PAGE        => $page,
			                   SEARCH_TYPE     => $s_type,
			                   SEARCH_TEXT     => $s_text,
			                   SEARCH_APPROVE  => $s_approve,
			                   SEARCH_PERIOD   => $s_period,
			                   SEARCH_YEAR1    => $s_year1,
			                   SEARCH_MONTH1   => $s_month1,
			                   SEARCH_DAY1     => $s_day1,
			                   SEARCH_YEAR2    => $s_year2,
			                   SEARCH_MONTH2   => $s_month2,
			                   SEARCH_DAY2     => $s_day2,
			                   SORT1_VALUE     => $sort1,
			                   SORT2_VALUE     => $sort2,
			                   DEFER_NUMBER    => $defer->deferNumber,
			                   DEFER_LNAME     => stripslashes($defer->deferFamilyName),
			                   DEFER_FNAME     => stripslashes($defer->deferGivenName),
			                   DEFER_MNAME     => stripslashes($defer->deferMiddleName),
			                   DEFER_STUDENT   => $defer->deferStudentID,
			                   DEFER_EMAIL     => $defer->deferEmail,
			                   DEFER_ADDRESS   => stripslashes($defer->deferAddress),
			                   DEFER_CITY      => stripslashes($defer->deferCity),
			                   DEFER_STATE     => stripslashes($defer->deferState),
			                   DEFER_POSTAL    => stripslashes($defer->deferPostal),
			                   DEFER_COUNTRY   => stripslashes($defer->deferCountry),
			                   DEFER_DEGREE1   => $degree1,
			                   DEFER_DEGREE2   => $degree2,
			                   DEFER_DEGREE3   => $degree3,
			                   DEFER_EXCHANGE1 => $exchange1,
			                   DEFER_EXCHANGE2 => $exchange2,
			                   DEFER_EXCHANGE3 => $exchange3,
			                   DEFER_POST2     => getEnglishDate(substr($defer->deferPost, 0, 10)),
			                   DEFER_APPROVE   => $defer->getApproveValue1($defer->deferApprove),
			                   DEFER_GRANT     => getEnglishDate($defer->deferGrant),
			                   DEFER_AMOUNT    => number_format($defer->deferAmount),
			                   DEFER_PAYMENT   => getEnglishDate($defer->getPaidDate($defer->deferApplyNo)),
			                   DEFER_DATE1     => getEnglishDate($defer->deferDate1),
			                   DEFER_DATE2     => getEnglishDate($defer->deferDate2),
			                   DEFER_APPLY_NO  => $defer->deferApplyNo,
			                   DEFER_PERIOD    => stripslashes($defer->deferPeriod),
			                   DEFER_EDIT      => $defer->deferEdit,
			                   DEFER_POST1     => $defer->deferPost,
			                   DEFER_ADMIN     => nl2br(stripslashes($defer->deferAdmin))));

			$detail = $defer->deferApplyNo . " 지원번호 납부연기 상세 정보 조회";
			$defer->insertHistoryWork("P", "I", $detail);

			$defer->closeDatabase();
			unset($defer);

			include_once("../common/footer_tpl.php");
		}
	}
?>