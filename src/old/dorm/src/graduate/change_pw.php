<?
	include_once("../../lib/conf.common.php");

	$no = $_GET["no"];
	$email = $_GET["email"];
	if ($no == "") $no = $_POST["no"];
	if ($email == "") $email = $_POST["email"];

	$html_dir = "graduate";
	$html_file = "change_pw";
	$on_load = "";

	$main_menu_index = 4;
	$page_menu_index = 10;
	$etc_menu_index = 0;

	include_once("../../src/common/tpl_header.php");

	$tpl->assign(array(STUDENT_NUMBER   => $no,
	                   STUDENT_EMAIL    => $email,
	                   STUDENT_PASSWORD => $pw));

	include_once("../../src/common/tpl_footer.php");
	include_once("../../src/common/counter_tpl.php");
?>