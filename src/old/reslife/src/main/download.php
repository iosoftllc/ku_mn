<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../../lib/func.common.php");
		$file = trim($_GET["file"]);
		$name = trim($_GET["name"]);
		if (trim($file) == "") $file = trim($_POST["file"]);
		if (trim($name) == "") $name = trim($_POST["name"]);
		$view = 1; // 1:다운 진행율 보임, 2:다운 진행율 안보임
		$speed = 400; // 다운속도 400KB
		$limit = 0; // 1:$speed로 다운속도 제한, 0:다운속도 무제한
		downloadFile($file, $name, $view, $speed, $limit);
	}
?>