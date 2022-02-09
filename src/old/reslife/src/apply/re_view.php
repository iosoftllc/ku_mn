<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] != 7 && (int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/refund_tpl.php");

			$page_name .= " 상세정보 보기";

			include_once("../common/header_tpl.php");

			$tpl->define_dynamic(array(trans_row    => "body",
			                           wire_row     => "body",
			                           money_row    => "body",
			                           overseas_row => "body",
			                           year_row     => "body",
			                           month_row    => "body"));

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

			$refund->getRefundInfo($no);

			$name = $refund->refundName3 . ", " . $refund->refundName1 . " " . $refund->refundName2;
			$old = $refund->refundSesseion1 . " (" . getEnglishDate($refund->refundSDate1) . " - " . getEnglishDate($refund->refundEDate1) . ")";
			if ($refund->refundSesseion2) {
				$new = $refund->refundSesseion2 . " (" . getEnglishDate($refund->refundSDate2) . " - " . getEnglishDate($refund->refundEDate2) . ")";
				$method = "";
			} else {
				$new = "";
				$method = " - " . $refund->getMethodValue($refund->refundMethod);
			}

			if ($refund->refundSesseion2) {
				$tpl->assign(array(REFUND_CF_APPLY   => $refund->refundCFApply,
				                   REFUND_CF_SESSION => $refund->refundSesseion2,
				                   REFUND_DATE       => getEnglishDate($refund->refundPost)));
				$tpl->parse(TRANS_ROWS, ".trans_row");
			} else if ($refund->refundMethod == "W") {
				$tpl->assign(array(WIRE_INFO1  => stripslashes($refund->refundMethod1),
				                   WIRE_INFO2  => stripslashes($refund->refundMethod2),
				                   WIRE_INFO3  => stripslashes($refund->refundMethod3),
				                   WIRE_REASON => stripslashes($refund->refundReason),
				                   REFUND_DATE => getEnglishDate($refund->refundPost)));
				$tpl->parse(WIRE_ROWS, ".wire_row");
			} else if ($refund->refundMethod == "M") {
				if ($refund->refundMethod3) $mail_name = "<br>Name of Mail Recipient: " . $refund->refundMethod3;
				else $mail_name = "";
				$tpl->assign(array(MONEY_INFO1 => stripslashes($refund->refundMethod1),
				                   MONEY_INFO2 => stripslashes($refund->refundMethod2),
				                   MONEY_INFO3 => stripslashes($mail_name),
				                   REFUND_DATE => getEnglishDate($refund->refundPost)));
				$tpl->parse(MONEY_ROWS, ".money_row");
			} else if ($refund->refundMethod == "O") {
				$tpl->assign(array(OVERSEAS_INFO1    => stripslashes($refund->refundMethod1),
				                   OVERSEAS_INFO2    => stripslashes($refund->refundMethod2),
				                   OVERSEAS_INFO3    => stripslashes($refund->refundMethod3),
				                   OVERSEAS_INFO4    => stripslashes($refund->refundMethod4),
				                   OVERSEAS_INFO5    => stripslashes($refund->refundMethod5),
				                   OVERSEAS_INFO6    => stripslashes($refund->refundMethod6),
				                   OVERSEAS_ADDRESS1 => stripslashes($refund->refundAddrLine2),
				                   OVERSEAS_ADDRESS2 => stripslashes($refund->refundAddrLine3),
				                   OVERSEAS_COUNTRY  => stripslashes($refund->refundAddrCountry),
				                   REFUND_DATE => getEnglishDate($refund->refundPost)));
				$tpl->parse(OVERSEAS_ROWS, ".overseas_row");
			}

			if ($s_kind == "L") {
				if ($refund->currentResident == "Y") $current = "KLCC Current Resident";
				else if ($refund->currentResident == "N") $current = "KLCC Prospect Resident (Deposit of 200,000 Korean won)";
				else $current = "";
			} else {
				if ($refund->currentResident == "Y") $current = "Current Resident";
				else if ($refund->currentResident == "N") $current = "Prospect Resident (Deposit of 200,000 Korean won)";
				else $current = "";
			}

			if ($refund->refundApply) $apply_no = $refund->refundApply;
			else $apply_no = "Not Provided";

			$tpl->assign(array(SEL_PAGE          => $page,
			                   SEARCH_TYPE       => $s_type,
			                   SEARCH_TEXT       => $s_text,
			                   SEARCH_APPROVE    => $s_app,
			                   SEARCH_KIND       => $s_kind,
			                   SEARCH_NEW        => $s_new,
			                   SEARCH_PERIOD     => $s_period,
			                   SORT1_VALUE       => $sort1,
			                   SORT2_VALUE       => $sort2,
			                   REFUND_NUMBER     => $no,
			                   REFUND_APPLY      => $apply_no,
			                   REFUND_APPROVE    => $refund->getApproveValue($refund->refundApprove),
			                   REFUND_KIND       => $refund->getKindValue($refund->refundKind),
			                   REFUND_DEDUCTION  => number_format($refund->refundDeduction),
			                   REFUND_DEDUCTION1 => number_format($refund->refundDeduction1),
			                   REFUND_DEDUCTION2 => number_format($refund->refundDeduction2),
			                   REFUND_DEDUCTION3 => number_format($refund->refundDeduction3),
			                   REFUND_STUDENT    => $refund->refundStudent,
			                   REFUND_NAME       => stripslashes($name),
			                   REFUND_DOB        => getEnglishDate($refund->refundDOB),
			                   REFUND_EMAIL      => $refund->refundEmail,
			                   REFUND_VACATE     => $refund->getVacateValue($refund->refundVacate),
			                   REFUND_DORM       => $refund->getDormitoryValue($refund->refundDorm),
			                   REFUND_ROOM       => $refund->refundRoom,
			                   REFUND_OLD        => stripslashes($old),
			                   REFUND_TYPE       => $refund->getRefundValue(stripslashes($new)),
			                   REFUND_REASON     => stripslashes($refund->refundReason),
			                   REFUND_METHOD     => $method,
			                   REFUND_APP_DATE   => getEnglishDate($refund->refundAppDate),
			                   REFUND_EDIT       => getEnglishDate($refund->refundEdit),
			                   REFUND_DATE       => getEnglishDate($refund->refundPost),
			                   REFUND_ADMIN      => nl2br(stripslashes($refund->refundAdmin)),
			                   TODAY_YEAR        => date("Y"),
			                   TODAY_MONTH       => date("m"),
			                   TODAY_DAY         => date("d"),
			                   REFUND_PHOTO      => getOriginalImage("$pht_dir/$no.jpg")));

			$detail = "$apply_no 지원번호 과납금 상세 정보 조회";
			$refund->insertHistoryWork("O", "I", $detail);

			$refund->closeDatabase();
			unset($refund);

			include_once("../common/footer_tpl.php");
		}
	}
?>