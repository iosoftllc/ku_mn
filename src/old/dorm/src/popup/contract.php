<?
	include_once("../../lib/conf.common.php");
	include_once("../../src/common/application_tpl.php");
	include_once("../../lib/class.rFastTemplate.php");

	$application->getApplicationInfo($no);
	$name = $application->personLastName . ", " . $application->personFirstName . " " . $application->personMiddleName;
	$date = substr($application->applyDate, 11, 2) . ":" . substr($application->applyDate, 14, 2) . ":" . substr($application->applyDate, 17, 2) . "/" . substr($application->applyDate, 8, 2) . "/" . substr($application->applyDate, 5, 2) . "/" . substr($application->applyDate, 0, 4);

	$tpl = new rFastTemplate("../../tpl/popup");
	$tpl->define(array(main => "contract.html"));

		$tpl->assign(array(STUDENT_NAME  => $name,
		                   CONTRACT_DATE => $date));

	$application->closeDatabase();
	unset($application);

	$tpl->parse(FINAL, "main");
	$tpl->FastPrint(FINAL);
?>