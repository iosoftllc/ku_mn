<?
	$tpl->parse(FINAL, "body");
	$body = $tpl->GetTemplate(FINAL);
	unset($tpl);

	$tpl = new rFastTemplate("../../tpl/main");

	$tpl->define(array(main => "main.html"));

	$tpl->define_dynamic(array(main_menu_row => "main",
	                           sub_menu_row  => "main",
	                           div_menu_row  => "main"));

	if (!is_numeric($main_index)) $main_index = -1;
	if (!is_numeric($sub_index)) $sub_index = -1;
	if ($main_index >= 0 && $sub_index >= 0 && !$page_name) $page_name = $submenu_name[$main_index][$sub_index];
	if ($main_index >= 0 && $sub_index >= 0 && !$menu_path) $menu_path = " >> <a href=\"" . $submenu_url[$main_index][0] . "\">" . $mainmenu_name[$main_index] . "</a> >> <a href=\"" . $submenu_url[$main_index][$sub_index] . "\">" . $submenu_name[$main_index][$sub_index] . "</a>";
	if ($main_index >= 0) $cur_main = $mainmenu_name[$main_index];
	else {
		$cur_main = "Ȩ";
		for ($i = 0; $i < count($mainmenu_name); $i++) {
			$tpl->assign(array(SUB_MENU_URL  => $submenu_url[$i][0],
			                   SUB_MENU_NAME => $mainmenu_name[$i]));
			$tpl->parse(SUB_MENU_ROWS, ".sub_menu_row");
		}
	}

	for ($i = 0; $i < count($mainmenu_name); $i++) {
		if ($i == $main_index) $tmp_name = "<b>" . $mainmenu_name[$i] . "</b>";
		else $tmp_name = $mainmenu_name[$i];
		$tpl->assign(array(MAIN_MENU_INDEX => $i + 1,
		                   MAIN_MENU_URL   => $submenu_url[$i][0],
		                   MAIN_MENU_NAME  => $tmp_name));
		$tpl->parse(MAIN_MENU_ROWS, ".main_menu_row");
		$div_list = "";
		for ($j = 0; $j < count($submenu_name[$i]); $j++) {
			if ($i == $main_index && $j == $sub_index) $div_list .= "<a href=\"" . $submenu_url[$i][$j] . "\"><b>" . $submenu_name[$i][$j] . "</b></a> | ";
			else $div_list .= "<a href=\"" . $submenu_url[$i][$j] . "\">" . $submenu_name[$i][$j] . "</a> | ";
			if ($i == $main_index) {
				if ($j == $sub_index) $tmp_name = "<b>" . $submenu_name[$i][$j] . "</b>";
				else $tmp_name = $submenu_name[$i][$j];
				$tpl->assign(array(SUB_MENU_URL  => $submenu_url[$i][$j],
				                   SUB_MENU_NAME => $tmp_name));
				$tpl->parse(SUB_MENU_ROWS, ".sub_menu_row");
			}
		}
		if ($div_list) $div_list = substr($div_list, 0, strlen($div_list) - 3);
		$tpl->assign(array(DIV_INDEX => $i + 1,
		                   DIV_LEFT  => $mainmenu_left[$i],
		                   DIV_WIDTH => $mainmenu_width[$i],
		                   DIV_LIST  => $div_list));
		$tpl->parse(DIV_MENU_ROWS, ".div_menu_row");
	}

	$tpl->assign(array(ADMIN_ID          => strtoupper($ihouse_admin_info[id]),
	                   ADMIN_NAME        => $ihouse_admin_info[name],
	                   PAGE_NAME         => $page_name,
	                   MENU_PATH         => $menu_path,
	                   ON_LOAD           => $on_load,
	                   MAIN_MENU_COUNT   => count($mainmenu_name),
	                   MAIN_MENU_INDEX   => ($main_index + 1),
	                   MAIN_COLSPAN      => (count($mainmenu_name) * 3) + 5,
	                   CURRENT_MAIN_MENU => $cur_main,
	                   BODY              => $body));

	$tpl->parse(FINAL, "main");
	$tpl->FastPrint(FINAL);
?>