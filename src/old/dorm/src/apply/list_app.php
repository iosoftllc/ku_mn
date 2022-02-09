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
		$html_file = "list_app";
		include_once("../../src/common/tpl_header.php");

		$tpl->define_dynamic(array(term_row => "body",
		                           list_use => "body",
		                           list_row => "body"));

		$application->getPeriodList3($email, "GEN");
		for ($i = 0; $i < count($application->periodCode); $i++) {
			$tpl->assign(array(TERM_CODE  => $application->periodCode[$i],
			                   TERM_APPLY => $application->periodApplyNo[$i],
			                   TERM_NAME  => stripslashes($application->periodName[$i]) . " (" . $application->periodSDate[$i] . " ~ " . $application->periodEDate[$i] . ")"));
			$tpl->parse(TERM_ROWS, ".term_row");
		}

		/*
		if ($s_state) {
			if ($sort1 == "") $sort = "";
			else $sort = $sort1 . " " . $sort2;
			$application->getApplicationList($email, $s_state, $sort);
			for ($i = 0; $i < count($application->appListNumber); $i++) {
				$line = "<tr><td colspan=\"7\" height=\"1\" background=\"../../images/board/board_hdot.jpg\"></td></tr>";
				if ($i == count($application->appListNumber) - 1) $line = "";
				$tpl->assign(array(LIST_NUMBER  => $application->appListNumber[$i],
				                   LIST_STATE   => $application->getStateValue($application->appListState[$i]),
				                   LIST_ROOM    => $application->appListRoomCode[$i],
				                   LIST_RATE    => stripslashes($application->appListRateName[$i]),
				                   LIST_PERIOD  => stripslashes($application->appListPeriodName[$i]),//stripslashes($application->appListPeriodName[$i]) . " (" . $application->appListPeriodSDate[$i] . " ~ " . $application->appListPeriodEDate[$i] . ")",
				                   LIST_DATE    => substr($application->appListDate[$i], 0, 10),
				                   DIVIDE_LINE  => $line));
				$tpl->parse(LIST_ROWS, ".list_row");
			}
			if (count($application->appListNumber)) $tpl->parse(LIST_USES, ".list_use");
		}
		*/

		$application->getStudentBasic($email);
		$info_no = $application->studentNumber;
		$info_nation = addslashes($application->studentNationality);
		$info_student = $application->studentID;
		$info_class = $application->studentClass;

		$tpl->assign(array(SEL_EMAIL    => $email,
		                   SEL_PASSWORD => $pw,
		                   SEARCH_STATE => $s_state,
		                   SORT1_VALUE  => $sort1,
		                   SORT2_VALUE  => $sort2,
		                   INFO_NUMBER  => $info_no,
		                   INFO_NATION  => $info_nation,
		                   INFO_STUDENT => $info_student,
		                   INFO_CLASS   => $info_class));

		$application->closeDatabase();
		unset($application);
	
		include_once("../../src/common/tpl_footer.php");
		include_once("../../src/common/counter_tpl.php");
	}
?>