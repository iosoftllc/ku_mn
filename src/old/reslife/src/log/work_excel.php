<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		header("Cache-control: private");

		include_once("../common/work_tpl.php");

		$filename .= "work_" . date("Ymd") . ".xls";
		header("Content-type: application/vnd.ms-excel");
		header("Content-type: application/vnd.ms-excel; charset=euc-kr");
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Description: PHP4 Generated Data");

		if ($sort1) $sort = $sort1 . " " . $sort2;
		else $sort = "";
		$historyWork->getWorkList("", "", $s_admin, $s_building, $s_menu, $s_kind, $sdate, $edate, $s_type, $s_text, $sort);
		$excel_str = "";
		$excel_str .= "<table border=\"1\">";
		$excel_str .= "<tr>";
		$excel_str .= "<td>업무시간</td>";
		$excel_str .= "<td>업무자아이디</td>";
		$excel_str .= "<td>업무자명</td>";
		$excel_str .= "<td>부서명</td>";
		$excel_str .= "<td>IP</td>";
		$excel_str .= "<td>건물</td>";
		$excel_str .= "<td>업무메뉴</td>";
		$excel_str .= "<td>업무종류</td>";
		$excel_str .= "<td>처리한 정보</td>";
		$excel_str .= "</tr>";
		for ($i = 0; $i < count($historyWork->workListNumber); $i++) {
			$excel_str .= "<tr>";
			$excel_str .= "<td>". $historyWork->workListTime[$i] . "</td>";
			$excel_str .= "<td>". $historyWork->workListName[$i] . "</td>";
			$excel_str .= "<td>". $historyWork->workListID[$i] . "</td>";
			$excel_str .= "<td>". $historyWork->workListDepartment[$i] . "</td>";
			$excel_str .= "<td>". $historyWork->workListIP[$i] . "</td>";
			$excel_str .= "<td>". $historyWork->getWorkBuidlingValue($historyWork->workListBuilding[$i]) . "</td>";
			$excel_str .= "<td>". $historyWork->getWorkMenuValue($historyWork->workListMenu[$i]) . "</td>";
			$excel_str .= "<td>". $historyWork->getWorkKindValue($historyWork->workListKind[$i]) . "</td>";
			$excel_str .= "<td>". $historyWork->workListDetail[$i] . "</td>";
			$excel_str .= "</tr>";
		}
		$excel_str .= "</table>";

		$historyWork->closeDatabase();
		unset($historyWork);

		echo "<meta content=\"application/vnd.ms-excel; charset=euc-kr\" name=\"Content-type\">";
		echo "<style>";
		echo "br { mso-data-placement:same-cell; }";
		echo "</style>";
		echo stripslashes($excel_str);
	}
?>