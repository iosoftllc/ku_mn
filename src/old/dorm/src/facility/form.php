<?
	include_once("../../lib/conf.common.php");

	$html_dir = "facility";
	$html_file = "form";
	$on_load = "document.FacilityForm.event.focus();";

	$main_menu_index = 3;
	$page_menu_index = 0;
	$etc_menu_index = 0;

	include_once("../../src/common/tpl_header.php");

	include_once("../../src/common/tpl_footer.php");
	include_once("../../src/common/counter_tpl.php");
?>