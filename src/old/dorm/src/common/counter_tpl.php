<?
	include_once("../../lib/conf.common.php");
	include_once("../../lib/class.cCounter.php");

	$counter = new cCounter($mysqlhost, $mysqluser, $mysqlpass, $mysqldb, $counterTable);
	$counter->connectDatabase();

	$option = $_GET["option"];
	if (!$option) $option = $_POST["option"];
	if (!$option) $option = "01";

	if ($option == "01") {
		$maxdate = $counter->getRecentDate($_SERVER["REMOTE_ADDR"]);
		if ($maxdate == "") $count_flag = true;
		else {
			$check_date = date("Y-m-d H:i:s", mktime(substr($maxdate, 11, 2) + 1, substr($maxdate, 14, 2), substr($maxdate, 17, 2), substr($maxdate, 5, 2), substr($maxdate, 8, 2), substr($maxdate, 0, 4)));
			if ($check_date < date("Y-m-d H:i:s")) $count_flag = true;
			else $count_flag = false;
		}
	} else if ($option == "02") $count_flag = true;
	else if ($option == "03") $count_flag = false;

	if ($count_flag) {
		$cnt_ip = $_SERVER["REMOTE_ADDR"];
		$cnt_agent = $_SERVER["HTTP_USER_AGENT"];
		$cnt_agent = str_replace("'", "''", $cnt_agent);
		$dim_cnt_agent = explode(";", $cnt_agent);
		if (count($dim_cnt_agent) > 1) {
			$cnt_brow = str_replace("MSIE", "Explorer", $dim_cnt_agent[1]);
			$cnt_os = $dim_cnt_agent[2];
			$cnt_os = str_replace("NT 5.1", "XP", str_replace("NT 5.0", "2000", str_replace(")", "", $cnt_os)));
		} else {
			$cnt_brow = "";
			$cnt_os = "";
		}
		$cnt_referer = $_SERVER["HTTP_REFERER"];
		$flag = $counter->insertCounter($cnt_agent, $cnt_referer, $cnt_brow, $cnt_os, $cnt_ip);
	}

	$ct_totalcnt = (int)$counter->getTotalCount() + 1000;
	$ct_image = "";
	for ($i = 0; $i < strlen($ct_totalcnt); $i++) {
		$ct_image .= "<img src=\"../../images/number/" . substr($ct_totalcnt, $i, 1) . ".jpg\" width=\"18\" height=\"16\">";
	}
	
	$counter->closeDatabase();
	unset($counter);
?>