<?
	include_once("../common/login_tpl.php");

	if ($log_flag) {
		if ((int)$ihouse_admin_info[grade] < 6 || (int)$ihouse_admin_info[grade] == 7 || (int)$ihouse_admin_info[grade] == 8) include_once("../common/check_auth_tpl.php");
		else {
			include_once("../common/grad_room_tpl.php");
			include_once("../common/header_tpl.php");

			$page_name .= " ผ๖มค";
			$room->getRoomInfo($code);

			$tpl->assign(array(MODE        => $mode,
			                   SEL_PAGE    => $page,
			                   SEARCH_RATE => $s_rate,
			                   SEARCH_TYPE => $s_type,
			                   SEARCH_TEXT => $s_text,
			                   SORT1_VALUE => $sort1,
			                   SORT2_VALUE => $sort2,
			                   ROOM_CODE   => $code,
			                   ROOM_RATE   => $room->roomRate,
			                   ROOM_PHONE  => $room->roomPhone,
			                   ROOM_IP     => $room->roomIP));

			$room->closeDatabase();
			unset($room);

			include_once("../common/footer_tpl.php");
		}
	}
?>