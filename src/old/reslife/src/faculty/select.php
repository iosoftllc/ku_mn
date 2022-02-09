<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		include_once("../common/faculty_tpl.php");

		$type = $_POST["type"];
		$code = $_POST["code"];
		$arr_yy = $_POST["arr_yy"];
		$arr_mm = $_POST["arr_mm"];
		$arr_dd = $_POST["arr_dd"];
		$det_yy = $_POST["det_yy"];
		$det_mm = $_POST["det_mm"];
		$det_dd = $_POST["det_dd"];
		if ($type == "") $type = $_GET["type"];
		if ($code == "") $code = $_GET["code"];
		if ($arr_yy == "") $arr_yy = $_GET["arr_yy"];
		if ($arr_mm == "") $arr_mm = $_GET["arr_mm"];
		if ($arr_dd == "") $arr_dd = $_GET["arr_dd"];
		if ($det_yy == "") $det_yy = $_GET["det_yy"];
		if ($det_mm == "") $det_mm = $_GET["det_mm"];
		if ($det_dd == "") $det_dd = $_GET["det_dd"];
		if ($arr_yy && $arr_mm && $arr_dd) $arrival = $arr_yy . "-" . $arr_mm . "-" . $arr_dd;
		else $arrival = "0000-00-00";
		if ($det_yy && $det_mm && $det_dd) $departure = $det_yy . "-" . $det_mm . "-" . $det_dd;
		else $departure = "0000-00-00";

		echo "<?xml version='1.0' encoding='EUC-KR'?>";
		echo "<xml>";
		switch ($type) {
			case "room":
				$faculty->getRoomList($code, $arrival, $departure);
				for ($i = 0; $i < count($faculty->roomListCode); $i++) {
					echo "<district>";
					echo "<code>" . $faculty->roomListCode[$i] . "</code>";
					echo "</district>";
				}
				break;
		}
		echo "</xml>";

		$faculty->closeDatabase();
		unset($faculty);
	}
?>