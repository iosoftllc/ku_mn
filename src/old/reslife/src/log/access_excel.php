<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		header("Cache-control: private");

		include_once("../common/access_tpl.php");

		$filename .= "access_" . date("Ymd") . ".xls";
		header("Content-type: application/vnd.ms-excel");
		header("Content-type: application/vnd.ms-excel; charset=euc-kr");
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Description: PHP4 Generated Data");

		if ($sort1) $sort = $sort1 . " " . $sort2;
		else $sort = "";
		$historyAccess->getAccessList("", "", $s_admin, $s_kind, $sdate, $edate, $s_type, $s_text, $sort);
		$excel_str = "";
		$excel_str .= "<table border=\"1\">";
		$excel_str .= "<tr>";
		$excel_str .= "<td>접속시간</td>";
		$excel_str .= "<td>접속자아이디</td>";
		$excel_str .= "<td>접속자명</td>";
		$excel_str .= "<td>부서명</td>";
		$excel_str .= "<td>IP</td>";
		$excel_str .= "<td>접속종류</td>";
		$excel_str .= "</tr>";
		for ($i = 0; $i < count($historyAccess->accessListNumber); $i++) {
			$excel_str .= "<tr>";
			$excel_str .= "<td>". $historyAccess->accessListTime[$i] . "</td>";
			$excel_str .= "<td>". $historyAccess->accessListName[$i] . "</td>";
			$excel_str .= "<td>". $historyAccess->accessListID[$i] . "</td>";
			$excel_str .= "<td>". $historyAccess->accessListDepartment[$i] . "</td>";
			$excel_str .= "<td>". $historyAccess->accessListIP[$i] . "</td>";
			$excel_str .= "<td>". $historyAccess->getAccessKindValue($historyAccess->accessListKind[$i]) . "</td>";
			$excel_str .= "</tr>";
		}
		$excel_str .= "</table>";

		$historyAccess->closeDatabase();
		unset($historyAccess);

		echo "<meta content=\"application/vnd.ms-excel; charset=euc-kr\" name=\"Content-type\">";
		echo "<style>";
		echo "br { mso-data-placement:same-cell; }";
		echo "</style>";
		echo stripslashes($excel_str);
	}
?>