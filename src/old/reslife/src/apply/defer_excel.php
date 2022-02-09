<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/defer_tpl.php");

			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$record = "������ȣ,���ο���,������ȣ,ü���Ⱓ,����й�,��,�̸�,�̸���,�ּ�,����,��ȯ�л�,������,������,���ο���ݾ�,�ֱټ�����,��û��,�����ڳ�Ʈ\n";
			$defer->getDeferList($sdate, $edate, "", "", $s_type, $s_text, $s_approve, $s_period, $sort);
			for ($i = 0; $i < count($defer->deferListNumber); $i++) {
				if ($defer->deferListGrant[$i] == "0000-00-00") $grant = "";
				else $grant = $defer->deferListGrant[$i];
				//if ($defer->deferListPayment[$i] == "0000-00-00") $pay = "";
				//else $pay = $defer->deferListPayment[$i];
			  $record .= "\"" . $defer->deferListNumber[$i] . "\",\"";
			  $record .= $defer->getApproveValue($defer->deferListApprove[$i]) . "\",\"";
			  $record .= $defer->deferListApplyNo[$i] . "\",\"";
			  $record .= $defer->deferListPeriod[$i] . "\",\"";
			  $record .= $defer->deferListStudentID[$i] . "\",\"";
			  $record .= $defer->deferListSurName[$i] . "\",\"";
			  $record .= $defer->deferListGivenName[$i] . "\",\"";
			  $record .= $defer->deferListEmail[$i] . "\",\"";
			  $record .= $defer->deferListAddress[$i] . "\",\"";
			  $record .= $defer->getClassValue($defer->deferListClass[$i]) . "\",\"";
			  $record .= $defer->deferListExchange[$i] . "\",\"";
			  $record .= $grant . "\",\"";
			  $record .= $pay . "\",\"";
			  $record .= $defer->deferListAmount[$i] . "\",\"";
			  $record .= $defer->deferListEdit[$i] . "\",\"";
			  $record .= $defer->deferListPost[$i] . "\",\"";
			  $record .= $defer->deferListAdmin[$i] . "\"\n";
			}
			$record = substr($record, 0, strlen($record) - 1);

			$purpose = $_GET["purpose"];
			if ($purpose == "") $purpose = $_POST["purpose"];
			$detail = "�� " . count($defer->deferListNumber) . "���� ���ο��� ���� �����ٿ�ε� - " . urldecode($purpose);
			$defer->insertHistoryWork("P", "X", $detail);

			$defer->closeDatabase();
			unset($defer);

			$csv_file = "../../../upload/temp.csv";
			$fp = fopen($csv_file, "w");
			fputs($fp, $record);
			fclose($fp);

			$date = date("Ymd");
			header("Content-type: application/octet-stream");
			header("Content-Length: " . filesize($csv_file));
			header("Content-Disposition: attachment; filename=defer_$date.csv");
			header("Content-Transfer-Encoding: binary");
			header("Pragma: no-cache");
			header("Expires: 0");

			$fp = fopen($csv_file, "r"); 
			if(!fpassthru($fp)) fclose($fp);

			unlink($csv_file);
		}
	}
?>