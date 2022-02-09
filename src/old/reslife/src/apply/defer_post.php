<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/defer_tpl.php");
			include_once("../common/header_tpl.php");
    	
			if ($mode == "edit") {
				$page_name .= " 수정";
				$defer->getDeferInfo($no);
				$name = stripslashes($defer->deferFamilyName);
				if ($defer->deferGivenName) $name .= ", " . stripslashes($defer->deferGivenName);
				if ($defer->deferMiddleName) $name .= " " . stripslashes($defer->deferMiddleName);
				$student_id = $defer->deferStudentID;
				$email = $defer->deferEmail;
				$address = $defer->deferAddress;
				if ($defer->deferCity) $address .= ", " . $defer->deferCity;
				if ($defer->deferState) $address .= ", " . $defer->deferState;
				if ($defer->deferCountry) $address .= ", " . $defer->deferCountry;
				if ($defer->deferPostal) $address .= " [" . $defer->deferPostal . "]";
				$address = stripslashes($address);
				$apply_no = $defer->deferApplyNo;
				$period = $defer->deferPeriod;
				$degree = $defer->getClassValue($defer->deferClass);
				$exchange = $defer->deferExchange;
				$approve = $defer->deferApprove;
				if ($defer->deferGrant == "0000-00-00") $grant = "";
				else $grant = $defer->deferGrant;
				$amount = number_format($defer->deferAmount);
				$pay = $defer->getPaidDate($defer->deferApplyNo);
				$admin = stripslashes($defer->deferAdmin);
			} else {
				$page_name .= " 추가";
				$no = "";
				$name = "";
				$student_id = "";
				$email = "";
				$address = "";
				$apply_no = "";
				$period = "";
				$degree = "";
				$exchange = "";
				$approve = "N";
				$grant = "";
				$amount = "";
				$pay = "";
				$admin = "";
			}

			$tpl->assign(array(MODE           => $mode,
			                   SEL_PAGE       => $page,
			                   SEARCH_TYPE    => $s_type,
			                   SEARCH_TEXT    => $s_text,
			                   SEARCH_APPROVE => $s_approve,
			                   SEARCH_PERIOD  => $s_period,
			                   SEARCH_YEAR1   => $s_year1,
			                   SEARCH_MONTH1  => $s_month1,
			                   SEARCH_DAY1    => $s_day1,
			                   SEARCH_YEAR2   => $s_year2,
			                   SEARCH_MONTH2  => $s_month2,
			                   SEARCH_DAY2    => $s_day2,
			                   SORT1_VALUE    => $sort1,
			                   SORT2_VALUE    => $sort2,
			                   DEFER_NUMBER   => $no,
			                   DEFER_NAME     => $name,
			                   DEFER_STUDENT  => $student_id,
			                   DEFER_EMAIL    => $email,
			                   DEFER_ADDRESS  => $address,
			                   DEFER_DEGREE   => $degree,
			                   DEFER_EXCHANGE => $exchange,
			                   DEFER_APPLY_NO => $apply_no,
			                   DEFER_PERIOD   => $period,
			                   DEFER_APPROVE  => $approve,
			                   DEFER_GRANT    => $grant,
			                   DEFER_AMOUNT   => $amount,
			                   DEFER_PAYMENT  => $pay,
			                   DEFER_ADMIN    => $admin));

			$defer->closeDatabase();
			unset($defer);

			include_once("../common/footer_tpl.php");
		}
	}
?>