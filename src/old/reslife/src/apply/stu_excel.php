<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/student_tpl.php");

			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$record = "�л�����,��翩��,����й�,��,�̸�,��Ī,�ѱۼ���,����,�������,����,��,Ȩ�ּ�,�����ּ�,�а�,�г�,KGSP,�̸���,��ȭ��ȣ,�ڵ�����ȣ,";
			$record .= "��޿���ó�̸�,��޿���ó����,��޿���ó��ȭ��ȣ,��޿���ó�ּ�,������,�����ڳ�Ʈ\n";
			$student->getStudentList($sdate, $edate, "", "", $s_type, $s_text, $s_kind, $s_current, $sort);
			for ($i = 0; $i < count($student->stuListNumber); $i++) {
				if ($student->stuListDOB[$i] == "0000-00-00") $dob = "";
				else $dob = getFullDate($student->stuListDOB[$i]);
				$record .= "\"" . $student->getKindValue($student->stuListKind[$i]) . "\",\"";
				$record .= $student->getCurrentValue($student->stuListCurrent[$i]) . "\",\"";
				$record .= $student->stuListID[$i] . "\",\"";
				$record .= $student->stuListLastName[$i] . "\",\"";
				$record .= $student->stuListFirstName[$i] . "\",\"";
				$record .= $student->stuListPreferName[$i] . "\",\"";
				$record .= $student->stuListKoreanName[$i] . "\",\"";
				$record .= $student->getGenderValue($student->stuListGender[$i]) . "\",\"" . $dob . "\",\"";
				$record .= $student->stuListNationality[$i] . "\",\"";
				$record .= $student->stuListUniversity[$i] . "\",\"";
				$record .= $student->stuListAddress[$i] . "\",\"";
				$record .= $student->stuListAddress1[$i] . "\",\"";
				$record .= $student->stuListMajor[$i] . "\",\"";
				$record .= $student->getClassValue($student->stuListClass[$i]) . "\",\"";
				$record .= $student->getKGSPValue($student->stuListKGSP[$i]) . "\",\"";
				$record .= $student->stuListEmail[$i] . "\",\"";
				$record .= $student->stuListPhone[$i] . "\",\"";
				$record .= $student->stuListMobile[$i] . "\",\"";
				$record .= $student->stuListCaseName[$i] . "\",\"";
				$record .= $student->stuListCaseRelate[$i] . "\",\"";
				$record .= $student->stuListCasePhone[$i] . "\",\"";
				$record .= $student->stuListCaseAddress[$i] . "\",\"";
				$record .= $student->stuListDate[$i] . "\",\"";
				$record .= $student->stuListAdmin[$i] . "\"\n";
			}
			$record = substr($record, 0, strlen($record) - 1);

			$purpose = $_GET["purpose"];
			if ($purpose == "") $purpose = $_POST["purpose"];
			$detail = "�� " . count($student->stuListNumber) . "���� ������ ���� �����ٿ�ε� - " . urldecode($purpose);
			$student->insertHistoryWork("S", "X", $detail);

			$student->closeDatabase();
			unset($student);

			$csv_file = "../../../upload/temp.csv";
			$fp = fopen($csv_file, "w");
			fputs($fp, $record);
			fclose($fp);

			$date = date("Ymd");
			header("Content-type: application/octet-stream");
			header("Content-Length: " . filesize($csv_file));
			header("Content-Disposition: attachment; filename=student_$date.csv");
			header("Content-Transfer-Encoding: binary");
			header("Pragma: no-cache");
			header("Expires: 0");

			$fp = fopen($csv_file, "r"); 
			if(!fpassthru($fp)) fclose($fp);

			unlink($csv_file);
		}
	}
?>