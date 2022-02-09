<?
	include_once("lib/conf.common.php");
	include_once("lib/class.cApplication.php");

	$no = array();

	$student = array();
	$student[] = "2005240026";
	$student[] = "2007950154";
	$student[] = "2007950168";
	$student[] = "2007950174";
	$student[] = "2007950181";
	$student[] = "2007950203";
	$student[] = "2007950208";
	$student[] = "2007950213";
	$student[] = "2007950214";
	$student[] = "2007950216";
	$student[] = "2007950264";
	$student[] = "2007950265";
	$student[] = "2007950266";
	$student[] = "2007950279";
	$student[] = "2007950314";
	$student[] = "2007950329";
	$student[] = "2007950364";
	$student[] = "2007950373";
	$student[] = "2007950375";
	$student[] = "2007950377";
	$student[] = "2007950378";
	$student[] = "2007950398";
	$student[] = "2007950400";

	$state = array();
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";
	$state[] = "PR";

	$application = new cApplication($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $studentTable, $applicantTable, $rateTable, $periodTable, $roomTable, $priceTable, $preferenceTable, $paymentTable, $accountTable);
	$application->connectDatabase();

	//for ($i = 0; $i < count($no); $i++) {
		//if ($no[$i] && $state[$i]) {
			//$flag = $application->updateApplicationState($no[$i], $state[$i]);
			//echo "" . ($i + 1) . " - " . $flag . "<br>";
		//}
	//}
	for ($i = 0; $i < count($student); $i++) {
		if ($student[$i] && $state[$i]) {
			$flag = $application->updateApplicationState1($student[$i], $state[$i]);
			if ($flag) echo "" . ($i + 1) . " - " . $student[$i] . " - 성공<br>";
			else echo "" . ($i + 1) . " - " . $student[$i] . " - 실패<br>";
		}
	}

	$application->closeDatabase();
	unset($application);
?>