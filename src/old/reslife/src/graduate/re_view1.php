<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 6 || (int)$ihouse_admin_info[grade] == 7 || (int)$ihouse_admin_info[grade] == 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/grad_refund_tpl.php");

			$page_name .= " 상세정보 보기";

			include_once("../common/header_tpl.php");

			$tpl->define_dynamic(array(wire_row     => "body",
			                           money_row    => "body",
			                           overseas_row => "body"));

			$refund->getRefundInfo($no);

			$name = $refund->refundName3 . ", " . $refund->refundName1 . " " . $refund->refundName2;
			$old = $refund->refundSesseion1;
			if ($refund->refundSesseion2) $new = $refund->refundSesseion2;
			else $new = "";

			if ($refund->refundMethod == "W") {
				$tpl->assign(array(WIRE_INFO1 => stripslashes($refund->refundMethod1),
				                   WIRE_INFO2 => stripslashes($refund->refundMethod2),
				                   WIRE_INFO3 => stripslashes($refund->refundMethod3)));
				$tpl->parse(WIRE_ROWS, ".wire_row");
			} else if ($refund->refundMethod == "M") {
				$tpl->assign(array(MONEY_INFO1 => stripslashes($refund->refundMethod1),
				                   MONEY_INFO2 => stripslashes($name),
				                   MONEY_INFO3 => stripslashes($refund->refundMethod2)));
				$tpl->parse(MONEY_ROWS, ".money_row");
			} else if ($refund->refundMethod == "O") {
				$tpl->assign(array(OVERSEAS_INFO1 => stripslashes($refund->refundMethod1),
				                   OVERSEAS_INFO2 => stripslashes($name),
				                   OVERSEAS_INFO3 => stripslashes($refund->refundMethod2)));
				$tpl->parse(OVERSEAS_ROWS, ".overseas_row");
			}

			if ($s_kind == "S") {
				if ($refund->currentResident == "Y") $current = "Special Current Resident";
				else if ($refund->currentResident == "N") $current = "Special Prospect Resident (Deposit of 200,000 Korean won)";
				else $current = "";
			} else {
				if ($refund->currentResident == "Y") $current = "Current Resident";
				else if ($refund->currentResident == "N") $current = "Prospect Resident (Deposit of 200,000 Korean won)";
				else $current = "";
			}

			if ($refund->refundApply) $apply_no = " (Application No. " . $refund->refundApply . ")";
			else $apply_no = "";
			if ($refund->refundCFApply) $cf_apply_no = " (Application No. " . $refund->refundCFApply . ")";
			else $cf_apply_no = "";

			$tpl->assign(array(SEL_PAGE         => $page,
			                   SEARCH_TYPE      => $s_type,
			                   SEARCH_TEXT      => $s_text,
			                   SEARCH_APPROVE   => $s_app,
			                   SEARCH_KIND      => $s_kind,
			                   SEARCH_NEW       => $s_new,
			                   SEARCH_PERIOD    => $s_period,
			                   SORT1_VALUE      => $sort1,
			                   SORT2_VALUE      => $sort2,
			                   REFUND_NUMBER    => $no,
			                   REFUND_APPLY     => $apply_no,
			                   REFUND_CF_APPLY  => $cf_apply_no,
			                   REFUND_APPROVE   => $refund->getApproveValue($refund->refundApprove),
			                   REFUND_KIND      => $refund->getKindValue($refund->refundKind),
			                   REFUND_DEDUCTION => number_format($refund->refundDeduction),
			                   REFUND_STUDENT   => $refund->refundStudent,
			                   REFUND_NAME      => stripslashes($name),
			                   REFUND_DOB       => getEnglishDate($refund->refundDOB),
			                   REFUND_EMAIL     => $refund->refundEmail,
			                   REFUND_VACATE    => $refund->getVacateValue($refund->refundVacate),
			                   REFUND_ROOM      => $refund->refundRoom,
			                   REFUND_OLD       => stripslashes($old),
			                   REFUND_TYPE      => $refund->getRefundValue(stripslashes($new)),
			                   REFUND_METHOD    => $refund->getMethodValue($refund->refundMethod),
			                   REFUND_EDIT      => getEnglishDate($refund->refundEdit),
			                   REFUND_DATE      => getEnglishDate($refund->refundPost),
			                   REFUND_ADMIN     => nl2br(stripslashes($refund->refundAdmin))));

			$refund->closeDatabase();
			unset($refund);

			include_once("../common/footer_tpl.php");
		}
	}
?>