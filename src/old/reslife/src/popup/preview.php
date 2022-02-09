<? 
	include_once("../../lib/conf.common.php");
	include_once("../../lib/class.rFastTemplate.php");

	$tpl = new rFastTemplate("../../tpl/$html_dir");
	$tpl->define(array(main => "$html_file.html"));

	$url = $_POST["url"];
	if ($url == "") $url = $_GET["url"];
	$tpl->assign(IMAGE_PATH, $url);

	$tpl->parse(FINAL, "main");
	$tpl->FastPrint(FINAL);
?>