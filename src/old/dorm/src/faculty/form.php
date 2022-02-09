<?
header("Location: ../../src/main/page.php?code=procedure_fe");
exit;
	/*
	include_once("../../lib/conf.common.php");
	include_once("../common/faculty_tpl.php");

	$html_dir = "faculty";
	$html_file = "form";
	$on_load = "document.FacultyForm.lname.focus();";

	$term = $_GET["term"];
	if (!$term) $term = $_POST["term"];
	if ($term != "L") $term = "S";

	include_once("../../src/common/tpl_header.php");

	$tpl->define_dynamic(array(year_row       => "body",
	                           month_row      => "body",
	                           rate_row       => "body",
	                           logn_term1_row => "body",
	                           logn_term2_row => "body",
	                           logn_term3_row => "body"));

	for ($i = 1930; $i <= date("Y"); $i++) {
		$tpl->assign(YEAR_VALUE, $i);
		$tpl->parse(YEAR_ROWS, ".year_row");
	}
	for ($i = 1; $i <= 12; $i++) {
		$temp = $i;
		if ($temp < 10) $temp = "0" . $temp;
		$tpl->assign(MONTH_VALUE, $temp);
		$tpl->parse(MONTH_ROWS, ".month_row");
	}

	$faculty->getRateList();
	for ($i = 0; $i < count($faculty->rateListCode); $i++) {
		if ($term == "S" && $faculty->rateListDormitory[$i] == "IFRH_FH") continue;
		if ($faculty->rateListDormitory[$i] == "ISRH_AN") continue;
		$tpl->assign(array(RATE_VALUE => $faculty->rateListCode[$i],
		                   RATE_NAME  => $faculty->getDormitoryValue($faculty->rateListDormitory[$i]) . " - " . $faculty->rateListUnit[$i]));
		$tpl->parse(RATE_ROWS, ".rate_row");
	}

	if ($term == "L") $mandatory = "*";
	else $mandatory = "";

	$tpl->assign(array(TERM_VALUE      => $term,
	                   MANDATORY_INPUT => $mandatory));

	if ($term != "S") {
		$tpl->parse(LOGN_TERM1_ROWS, ".logn_term1_row");
		$tpl->parse(LOGN_TERM2_ROWS, ".logn_term2_row");
		$tpl->parse(LOGN_TERM3_ROWS, ".logn_term3_row");
	}

	include("../common/tpl_variables.php");

	$faculty->closeDatabase();
	unset($faculty);

	include_once("../../src/common/tpl_footer.php");
	include_once("../../src/common/counter_tpl.php");
	*/
?>