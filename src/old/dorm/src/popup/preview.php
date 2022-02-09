<? 
	include_once("../../lib/conf.common.php");
	include_once("../../lib/class.rFastTemplate.php");

	$tpl = new rFastTemplate("../../tpl/popup");
	$tpl->define(array(main => "preview.html"));

	$url = $_POST["url"];
	if ($url == "") $url = $_GET["url"];
	$tpl->assign(array(IMAGE_PATH => $url));

	$tpl->parse(FINAL, "main");
	$tpl->FastPrint(FINAL);
?>