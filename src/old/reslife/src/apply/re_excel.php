<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/refund_tpl.php");

			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$record = "인덱스,학생종류,지원번호,이전지원번호,고대학번,환불종류,승인여부,Deposit Paid,Overpayment,Total Deposit Payment,Damage Deduction,Cancellation Fee,Late Check out,차감액,반환 및 이전 금액,신청체류기간,적용체류기간,룸번호,성,이름,생년월일,이메일,국적,최근수정일,승인일,신청일,퇴실일,환불방법,환불정보1,환불정보2,환불정보3,환불이유,기숙사,관리자노트\n";
			$refund->getExcelList($sdate, $edate, $s_type, $s_text, $s_kind, $s_new, $s_app, $s_period, $sort);
			for ($i = 0; $i < count($refund->listNumber); $i++) {
				if ($refund->listKind[$i] == "U") $kind = "Regular";
				else if ($refund->listKind[$i] == "L") $kind = "KLCC";
				else $kind = "";
				if (substr($refund->listEdit[$i], 0, 10) == "0000-00-00") $edit_dt = "";
				else $edit_dt = substr($refund->listEdit[$i], 0, 10);
				if (substr($refund->listAppDate[$i], 0, 10) == "0000-00-00") $app_dt = "";
				else $app_dt = substr($refund->listAppDate[$i], 0, 10);
				$paid = $refund->getDepositPaid($refund->listApply[$i]);
				$overpay = $refund->getOverpayment($refund->listApply[$i]);
				$total = $paid + $overpay;
				$record .= "\"" . $refund->listNumber[$i] . "\",\"";
				$record .= $kind . "\",\"";
				$record .= $refund->listApply[$i] . "\",\"";
				$record .= $refund->listCFApply[$i] . "\",\"";
				$record .= $refund->listStudent[$i] . "\",\"";
				$record .= $refund->getRefundValue1($refund->listSession2[$i], $refund->listPayMethod[$i]) . "\",\"";
				$record .= $refund->getApproveValue($refund->listApprove[$i]) . "\",\"";

				$record .= abs($paid) . "\",\"";
				$record .= abs($overpay) . "\",\"";
				$record .= abs($total) . "\",\"";
				$record .= $refund->getDamageDeduction($refund->listApply[$i]) . "\",\"";
				$record .= $refund->getCancellationFee($refund->listApply[$i]) . "\",\"";
				$record .= $refund->getLateCheckout($refund->listApply[$i]) . "\",\"";

				$record .= $refund->listDeduction[$i] . "\",\"";

				$record .= (abs($total) - (int)$refund->listDeduction[$i]) . "\",\"";

				$record .= $refund->listSession1[$i] . "\",\"";
				$record .= $refund->listSession2[$i] . "\",\"";
				$record .= $refund->listRoom[$i] . "\",\"";
				$record .= $refund->listName2[$i] . "\",\"";
				$record .= $refund->listName1[$i] . "\",\"";
				$record .= $refund->listBirth[$i] . "\",\"";
				$record .= $refund->listEmail[$i] . "\",\"";
				$record .= $refund->listNation[$i] . "\",\"";
				$record .= $edit_dt . "\",\"";
				$record .= $app_dt . "\",\"";
				$record .= substr($refund->listDate[$i], 0, 10) . "\",\"";
				$record .= $refund->getVacateValue($refund->listVacate[$i]) . "\",\"";
				$record .= $refund->getMethodValue($refund->listMethod[$i]) . "\",\"";
				$record .= $refund->listMethod1[$i] . "\",\"";
				$record .= $refund->listMethod2[$i] . "\",\"";
				$record .= $refund->listMethod3[$i] . "\",\"";
				$record .= $refund->listReason[$i] . "\",\"";
				$record .= $refund->getDormitoryValue($refund->listDorm[$i]) . "\",\"";
				$record .= $refund->listAdmin[$i] . "\"\n";
			}
			$record = substr($record, 0, strlen($record) - 1);

			$purpose = $_GET["purpose"];
			if ($purpose == "") $purpose = $_POST["purpose"];
			$detail = "총 " . count($refund->listNumber) . "개의 과납금 정보 엑셀다운로드 - " . urldecode($purpose);
			$refund->insertHistoryWork("O", "X", $detail);

			$refund->closeDatabase();
			unset($refund);

			$csv_file = "../../../upload/temp.csv";
			$fp = fopen($csv_file, "w");
			fputs($fp, $record);
			fclose($fp);
    
			$date = date("Ymd");
			header("Content-type: application/octet-stream");
			header("Content-Length: " . filesize($csv_file));
			header("Content-Disposition: attachment; filename=deposit_$date.csv");
			header("Content-Transfer-Encoding: binary");
			header("Pragma: no-cache");
			header("Expires: 0");

			$fp = fopen($csv_file, "r"); 
			if(!fpassthru($fp)) fclose($fp);
    
			unlink($csv_file);
		}
	}
?>