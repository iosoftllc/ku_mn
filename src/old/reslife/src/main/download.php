<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../../lib/func.common.php");
		$file = trim($_GET["file"]);
		$name = trim($_GET["name"]);
		if (trim($file) == "") $file = trim($_POST["file"]);
		if (trim($name) == "") $name = trim($_POST["name"]);
		$view = 1; // 1:�ٿ� ������ ����, 2:�ٿ� ������ �Ⱥ���
		$speed = 400; // �ٿ�ӵ� 400KB
		$limit = 0; // 1:$speed�� �ٿ�ӵ� ����, 0:�ٿ�ӵ� ������
		downloadFile($file, $name, $view, $speed, $limit);
	}
?>