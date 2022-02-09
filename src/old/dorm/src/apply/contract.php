<?
	include_once("../../lib/conf.common.php");
	include_once("../../lib/class.cApplicant.php");

	$kind = $_POST["kind"];
	$current = $_POST["current"];
	$apply_no = $_POST["apply_no"];
	$student_no = $_POST["student_no"];
	$apply_fname = $_POST["apply_fname"];
	$apply_mname = $_POST["apply_mname"];
	$apply_lname = $_POST["apply_lname"];
	if ($kind == "") $kind = $_GET["kind"];
	if ($current == "") $current = $_GET["current"];
	if ($apply_no == "") $apply_no = $_GET["apply_no"];
	if ($student_no == "") $student_no = $_GET["student_no"];
	if ($apply_fname == "") $apply_fname = $_GET["apply_fname"];
	if ($apply_mname == "") $apply_mname = $_GET["apply_mname"];
	if ($apply_lname == "") $apply_lname = $_GET["apply_lname"];
	if ($kind != "L") $kind = "U";
	if ($current != "Y") $current = "N";

	$cur_dt = date("Y-m-d");
	$cur_time = date("H");
	//$cur_dt = "2006-11-09";
	//$cur_time = 12;

	$applicant = new cApplicant($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $applicantTable, $rateTable, $periodTable, $roomTable, $priceTable, $preferenceTable, $paymentTable);
	$applicant->connectDatabase();
	//$apply_no = $applicant->getApplicantNumber($student_no, $apply_fname, $apply_mname, $apply_lname);
	//$u_state = $applicant->checkApplicantState($student_no, "", $apply_fname, $apply_mname, $apply_lname);
	//$l_state = $applicant->checkApplicantState($student_no, "", $apply_fname, $apply_mname, $apply_lname);
	$exist_flag = $applicant->isExist($apply_no, $apply_fname, $apply_mname, $apply_lname);
	$u_state = $applicant->checkApplicantState1($apply_no, "");
	$l_state = $applicant->checkApplicantState1($apply_no, "");
	if ($apply_no == "" && $apply_fname == "" && $apply_mname == "" && $apply_lname == "") $current = "N";
	else $current = "Y";

	if ($cur_dt < "2006-11-06") {
		$applicant->closeDatabase();
		unset($applicant);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Application period for Winter 2007 is from November 6 through November 10, 2006.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($cur_dt > "2006-11-10" && !($cur_dt == "2006-11-15" && (int)$cur_time >= 9 && (int)$cur_time < 12)) {
		$applicant->closeDatabase();
		unset($applicant);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Application period for Spring 2007 is from January 3 through January 12, 2007.\");";
		echo "history.go(-1);";
		echo "</script>";
	//} else if ($current == "Y" && !$exist_flag) {
	} else if (!$exist_flag) {
		$applicant->closeDatabase();
		unset($applicant);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"There is no matching data available.\\n\\nCheck your application information.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($kind == "U" && $current == "Y" && !($u_state == "FD" || $u_state == "FS")) {
		$applicant->closeDatabase();
		unset($applicant);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Sorry, your application is not available.\\n\\nPlease visit the residence life office to resolve the issue.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else if ($kind == "L" && $current == "Y" && !($l_state == "FD" || $l_state == "FS")) {
		$applicant->closeDatabase();
		unset($applicant);
		echo "<script langauage=\"javascript\">";
		echo "alert(\"Sorry, your application is not available.\\n\\nPlease visit the residence life office to resolve the issue.\");";
		echo "history.go(-1);";
		echo "</script>";
	} else {
		$html_dir = "apply";
		$html_file = "contract";
		$on_load = "document.location.href='#';";

		if ($kind == "L") {
			$s_kind = "LAN";
			if ($current == "Y") $title_img = "<td width=\"311\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_l.jpg\" width=\"501\" height=\"23\"></td>";
			else $title_img = "<td width=\"311\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_l.jpg\" width=\"501\" height=\"23\"></td>";
		} else {
			$s_kind = "GEN";
			//if ($current == "Y") $title_img = "<td width=\"311\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_c.jpg\" width=\"311\" height=\"23\"></td>";
			//else $title_img = "<td width=\"318\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_n.jpg\" width=\"318\" height=\"23\"></td>";
			$title_img = "<td width=\"290\" rowspan=\"2\" nowrap><img src=\"../../images/title/page_apply_new.jpg\" width=\"290\" height=\"23\"></td>";
		}

		include_once("../../lib/func.common.php");
		include_once("../../src/common/tpl_header.php");

		$tpl->assign(array(CURRENT_KIND  => $kind,
		                   CURRENT_VALUE => $current,
		                   TITLE_IMAGE   => $title_img,
		                   APPLY_NUMBER  => $apply_no,
		                   APPLY_LNAME   => $apply_lname,
		                   APPLY_FNAME   => $apply_fname,
		                   APPLY_MNAME   => $apply_mname));

		$applicant->closeDatabase();
		unset($applicant);

		include_once("../../src/common/tpl_footer.php");
		include_once("../../src/common/counter_tpl.php");
	}
?>