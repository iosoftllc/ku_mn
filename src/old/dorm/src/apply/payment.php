<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/application_tpl.php");

	$on_load = "";

	if (!$application->isEmailExist($email)) {
		$application->closeDatabase();
		unset($application);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"There is no matching personal data available.\\n\\nCheck your personal information.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if (!$application->checkPassword($email, $pw)) {
		$application->closeDatabase();
		unset($application);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"The password you input is not correct.\\n\\nPlease try again later.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else {
		$html_dir = "apply";
		$html_file = "payment";
		include_once("../../src/common/tpl_header.php");

		$tpl->define_dynamic(session_row, "body");

		$application->getPeriodList3($email, "GEN");
		for ($i = 0; $i < count($application->periodCode); $i++) {
			$no = $application->periodApplyNo[$i];
			$deposit_list = "";
			$deposit_total = 0;
			$application->getPaymentList1($no);
			for ($j = 0; $j < count($application->payListNumber); $j++) {
				$deposit_list .= "<tr>";
				$deposit_list .= "<td width=\"1\" nowrap></td>";
				$deposit_list .= "<td width=\"9\" nowrap></td>";
				$deposit_list .= "<td width=\"130\" height=\"21\" nowrap>" . getEnglishDate(substr($application->payListDate[$j], 0, 10)) . "</td>";
				$deposit_list .= "<td width=\"10\" nowrap></td>";
				$deposit_list .= "<td height=\"21\">" . $application->getDetailValue($application->payListDetail[$j]) . "</td>";
				$deposit_list .= "<td width=\"10\" nowrap></td>";
				$deposit_list .= "<td width=\"120\" height=\"21\" align=\"right\" nowrap>" . number_format($application->payListPrice[$j]) . " KRW</td>";
				$deposit_list .= "<td width=\"9\" nowrap></td>";
				$deposit_list .= "<td width=\"1\" nowrap></td>";
				$deposit_list .= "</tr>";
				$deposit_list .= "<tr>";
				$deposit_list .= "<td colspan=\"9\" height=\"1\"></td>";
				$deposit_list .= "</tr>";
				$deposit_list .= "<tr>";
				$deposit_list .= "<td colspan=\"9\" height=\"1\" background=\"../../images/board/board_hdot.jpg\"></td>";
				$deposit_list .= "</tr>";
				$deposit_list .= "<tr>";
				$deposit_list .= "<td colspan=\"9\" height=\"1\"></td>";
				$deposit_list .= "</tr>";
				$deposit_total += (int)$application->payListPrice[$j];
			}
			$fee_list = "";
			$fee_total = 0;
			$application->getPaymentList2($no);
			for ($j = 0; $j < count($application->payListNumber); $j++) {
				$fee_list .= "<tr>";
				$fee_list .= "<td width=\"1\" nowrap></td>";
				$fee_list .= "<td width=\"9\" nowrap></td>";
				$fee_list .= "<td width=\"130\" height=\"21\" nowrap>" . getEnglishDate(substr($application->payListDate[$j], 0, 10)) . "</td>";
				$fee_list .= "<td width=\"10\" nowrap></td>";
				$fee_list .= "<td height=\"21\">" . $application->getDetailValue($application->payListDetail[$j]) . "</td>";
				$fee_list .= "<td width=\"10\" nowrap></td>";
				$fee_list .= "<td width=\"120\" height=\"21\" align=\"right\" nowrap>" . number_format($application->payListPrice[$j]) . " KRW</td>";
				$fee_list .= "<td width=\"9\" nowrap></td>";
				$fee_list .= "<td width=\"1\" nowrap></td>";
				$fee_list .= "</tr>";
				$fee_list .= "<tr>";
				$fee_list .= "<td colspan=\"9\" height=\"1\"></td>";
				$fee_list .= "</tr>";
				$fee_list .= "<tr>";
				$fee_list .= "<td colspan=\"9\" height=\"1\" background=\"../../images/board/board_hdot.jpg\"></td>";
				$fee_list .= "</tr>";
				$fee_list .= "<tr>";
				$fee_list .= "<td colspan=\"9\" height=\"1\"></td>";
				$fee_list .= "</tr>";
				$fee_total += (int)$application->payListPrice[$j];
			}
			$carry_forward = "";
			if ($i == 0 && (int)$application->getDepositPaidAmount($no) == 0) {
				$carry_forward .= "<input type=\"hidden\" name=\"mode\" value=\"transfer\">";
				$carry_forward .= "<input type=\"hidden\" name=\"refund_flag\" value=\"N\">";
				$carry_forward .= "<input type=\"hidden\" name=\"cf_no\" value=\"$no\">";
				$carry_forward .= "<tr>";
				$carry_forward .= "<td height=\"5\"></td>";
				$carry_forward .= "</tr>";
				$carry_forward .= "<tr>";
				$carry_forward .= "<td align=\"center\">";
				$carry_forward .= "<b>Deposit Carry Forward From: </b>";
				$carry_forward .= "<select name=\"no\">";
				$carry_forward .= "<option value=\"\">Select the application number.</option>";
				for ($j = 1; $j < count($application->periodCode); $j++) {
					$temp_no = $application->periodApplyNo[$j];
					if ((int)$application->getDepositPaidAmount($temp_no)) $carry_forward .= "<option value=\"$temp_no\">$temp_no</option>";
				}
				$carry_forward .= "</select> ";
				$carry_forward .= "<a href=\"javascript:submitCarryForward(document.PaymentForm);\"><img src=\"../../images/button/btn_request.jpg\" border=\"0\" align=\"absmiddle\"></a>";
				$carry_forward .= "</td>";
				$carry_forward .= "</tr>";
			}
			$tpl->assign(array(SESSION_NAME          => stripslashes($application->periodName[$i]) . " (" . $application->periodSDate[$i] . " ~ " . $application->periodEDate[$i] . ") # $no",
			                   SESSION_DEPOSIT_LIST  => $deposit_list,
			                   SESSION_DEPOSIT_TOTAL => number_format($deposit_total),
			                   SESSION_FEE_LIST      => $fee_list,
			                   SESSION_FEE_TOTAL     => number_format($fee_total),
			                   SESSION_CARRY_FORWARD => $carry_forward));
			$tpl->parse(SESSION_ROWS, ".session_row");
		}

		$tpl->assign(array(SEL_EMAIL    => $email,
		                   SEL_PASSWORD => $pw,
		                   SEARCH_STATE => $s_state,
		                   SORT1_VALUE  => $sort1,
		                   SORT2_VALUE  => $sort2));

		$application->closeDatabase();
		unset($application);

		include_once("../../src/common/tpl_footer.php");
		include_once("../../src/common/counter_tpl.php");
	}
?>