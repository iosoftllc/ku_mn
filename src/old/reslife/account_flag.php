<?
	include_once("lib/conf.common.php");
	include_once("lib/class.cApplicant.php");

	$student = array();
	$student[] = "2005950095";
	$student[] = "2005950118";
	$student[] = "2005950136";
	$student[] = "2005950145";
	$student[] = "2005950150";
	$student[] = "2005950187";
	$student[] = "2005950210";
	$student[] = "2005950214";
	$student[] = "2005950227";
	$student[] = "2005950228";
	$student[] = "2006472003";
	$student[] = "2006950007";
	$student[] = "2006950022";
	$student[] = "2006950030";
	$student[] = "2006950037";
	$student[] = "2006950038";
	$student[] = "2006950061";
	$student[] = "2006950062";
	$student[] = "2006950076";

	$applicant = new cApplicant($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $applicantTable, $rateTable, $periodTable, $roomTable, $priceTable, $preferenceTable, $paymentTable);
	$applicant->connectDatabase();

	for ($i = 0; $i < count($student); $i++) {
		if ($student[$i]) {
			$flag = $applicant->updateAccountFlag($student[$i]);
			if ($flag) echo "" . ($i + 1) . " - 성공<br>";
			else echo "" . ($i + 1) . " - 실패<br>";
		}
		//echo $no[$i] . " " . $rate[$i] . " " . $period[$i] . "<br>";
	}

	$applicant->closeDatabase();
	unset($applicant);
?>