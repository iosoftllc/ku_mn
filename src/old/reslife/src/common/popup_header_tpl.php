<?
	include_once("../../lib/conf.common.php");
	include_once("../../lib/class.rFastTemplate.php");

	if ($html_dir == "popup" && ($html_file == "room_mail_f" || $html_file == "room_mail_h")) {
		$tpl = new rFastTemplate("../../../tpl/main");
		$tpl->define(array(body => "letter.html"));
	} else {
		if (!file_exists("../../tpl/$html_dir/$html_file.html")) $html_file = "../main/not_found";
		$tpl = new rFastTemplate("../../tpl/$html_dir");
		$tpl->define(array(body => "$html_file.html"));
	}
?>