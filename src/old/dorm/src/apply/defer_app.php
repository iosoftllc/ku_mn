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
		$application->getApplicationInfo($no);
		if ($application->applyNumber) {
			$html_dir = "apply";
			$html_file = "defer_app";
			include_once("../../src/common/tpl_header.php");

			$application->getDeferInfo($no);
			$degree1 = $degree2 = $degree3 = $exchange1 = $exchange2 = $exchange3 = "(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)";
			if ($application->deferClass == "F" || $application->deferClass == "P" || $application->deferClass == "J" || $application->deferClass == "S") $degree1 = "( 0 )";
			else if ($application->deferClass == "M") $degree2 = "( 0 )";
			else if ($application->deferClass == "D") $degree3 = "( 0 )";

			$tpl->assign(array(SEL_EMAIL       => $email,
			                   SEL_PASSWORD    => $pw,
			                   SEARCH_STATE    => $s_state,
			                   SORT1_VALUE     => $sort1,
			                   SORT2_VALUE     => $sort2,
			                   APPLY_NUMBER    => $no,
			                   DEFER_NUMBER    => $application->deferNumber,
			                   DEFER_LNAME     => stripslashes($application->deferFamilyName),
			                   DEFER_FNAME     => stripslashes($application->deferGivenName),
			                   DEFER_MNAME     => stripslashes($application->deferMiddleName),
			                   DEFER_STUDENT   => $application->deferStudentID,
			                   DEFER_EMAIL     => $application->deferEmail,
			                   DEFER_ADDRESS   => stripslashes($application->deferAddress),
			                   DEFER_CITY      => stripslashes($application->deferCity),
			                   DEFER_STATE     => stripslashes($application->deferState),
			                   DEFER_POSTAL    => stripslashes($application->deferPostal),
			                   DEFER_COUNTRY   => stripslashes($application->deferCountry),
			                   DEFER_DEGREE1   => $degree1,
			                   DEFER_DEGREE2   => $degree2,
			                   DEFER_DEGREE3   => $degree3,
			                   DEFER_POST2     => getEnglishDate(date("Y-m-d")),
			                   DEFER_AMOUNT    => number_format($application->deferAmount),
			                   DEFER_DATE1     => getEnglishDate($application->deferDate1),
			                   DEFER_DATE2     => getEnglishDate($application->deferDate2),
			                   DEFER_APPLY_NO  => $application->deferApplyNo,
			                   DEFER_PERIOD    => stripslashes($application->deferPeriod)));

			$application->closeDatabase();
			unset($application);
		
			include_once("../../src/common/tpl_footer.php");
			include_once("../../src/common/counter_tpl.php");
		} else {
			$application->closeDatabase();
			unset($application);
			echo "<script langauage=\"javascript\">";
			echo "alert(\"There is not correspondant application.\\n\\nPlease try again later.\");";
			echo "history.go(-1);";
			echo "</script>";
		}
	}
?>