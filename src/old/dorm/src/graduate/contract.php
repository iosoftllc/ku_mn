<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/grad_application_tpl.php");

	$cur_dt = date("Y-m-d");
	//$cur_dt = "2021-08-06";

	if ($cur_dt < "2021-08-06") {
		$application->closeDatabase();
		unset($application);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"The online application for the 2021-2nd semester will be from August 6, 2021 to August 12, 2021.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($cur_dt > "2021-08-12") {
		$application->closeDatabase();
		unset($application);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"The online application for the 2021-2nd semester is now closed.\\n\\nNow we have so many applicants that we couldn¡¯t expect over the limit of occupancy.\\n\\nWaiting list for housing is already full. Thanks\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if (!$application->isEmailExist($email)) {
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
		$html_dir = "graduate";
		$html_file = "contract";
		$on_load = "";

		$application->getCheckInfo($email);
		$current = $application->studentCurrent;
		$name = stripslashes($application->studentFirstName . " " . $application->studentMiddleName . " " . $application->studentLastName);

		if ($current == "Y") $title_img = "<td width=\"311\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_l.jpg\" width=\"501\" height=\"23\"></td>";
		else $title_img = "<td width=\"311\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_l.jpg\" width=\"501\" height=\"23\"></td>";

		include_once("../../src/common/tpl_header.php");

		$tpl->assign(array(TITLE_IMAGE      => $title_img,
		                   STUDENT_EMAIL    => $email,
		                   STUDENT_PASSWORD => $pw,
		                   STUDENT_NAME     => $name,
		                   CURRENT_DATE     => date("H:i:s/d/m/Y")));

		$application->closeDatabase();
		unset($application);

		include_once("../../src/common/tpl_footer.php");
		include_once("../../src/common/counter_tpl.php");
	}
?>