<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../common/grad_refund_tpl.php");

		$type = $_POST["type"];
		if ($type == "") $type = $_GET["type"];

		$json = "\r\n{\"period\":[";
		switch ($type) {
			case "deposit":
				$refund->getPeriodList();
				for ($i = 0; $i < count($refund->periodCode); $i++) {
					$json .= "\r\n{\"code\":\"" . $refund->periodCode[$i] . "\",\"name\":\"" . $refund->periodName[$i] . "\",\"sdate\":\"" . getEnglishDate($refund->periodSDate[$i]) . "\",\"edate\":\"" . getEnglishDate($refund->periodEDate[$i]) . "\"},";
				}
				if (count($refund->periodCode)) $json = substr($json, 0, -1);
				break;
		}
		$json .= "\r\n]}";
		header("Content-type: text/xml; charset=euc-kr"); 
		header("Cache-Control: no-cache");
		echo $json;

		$refund->closeDatabase();
		unset($refund);
	}
?>