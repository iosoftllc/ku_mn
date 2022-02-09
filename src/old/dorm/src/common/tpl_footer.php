<?
	$tpl->parse(FINAL, "body");
	$body = $tpl->GetTemplate(FINAL);
	unset($tpl);

	$tpl = new rFastTemplate("../../tpl/main");
	$tpl->define(array(main => "main.html"));

	$tpl->define_dynamic(array(main_menu_row   => "main",
	                           main_img_row    => "main",
	                           sub_menu_row    => "main",
	                           sub_img_row     => "main",
	                           page_menu_row   => "main",
	                           page_img_row    => "main",
	                           etc_menu_row    => "main",
	                           etc_img_row     => "main",
	                           footer_menu_row => "main",
	                           footer_img_row  => "main",
	                           page_title_row  => "main"));

	// 메인메뉴, 서브메뉴, 페이지메뉴 구성
	for ($i = 0; $i < $main_menu_count; $i++) {
		$temp_menu_index = $i + 1;
		$main_menu_id = "main_menu_" . $temp_menu_index;
		$main_menu_file = "../../images/menu/$main_menu_id.jpg";
		$main_menu_over = "../../images/menu/o_$main_menu_id.jpg";
		if (file_exists($main_menu_file) && file_exists($main_menu_over)) {
			$img_size = getimagesize($main_menu_file);
			$tpl->assign(MAIN_MENU_IMAGE, "<a href=\"" . $main_menu_url[$i] . "\"><img id=\"$main_menu_id\" src=\"$main_menu_file\" width=\"$img_size[0]\" height=\"$img_size[1]\" onMouseover=\"swapMenu(this.id, 'over');\" onMouseout=\"swapMenu(this.id, 'out');\"></a>");
			$tpl->parse(MAIN_MENU_ROWS, ".main_menu_row");
			$tpl->assign(array(MAIN_IMG_INDEX  => $i,
			                   MAIN_OUT_FILE   => $main_menu_file,
			                   MAIN_OVER_FILE  => $main_menu_over));
			$tpl->parse(MAIN_IMG_ROWS, ".main_img_row");
		}
		$sub_menu_list = "";
		for ($j = 0; $j < count($page_menu_name[$i]); $j++) {
			$sub_menu_id = "sub_menu_" . ($i + 1) . "_" . ($j + 1);
			$sub_menu_list .= "<tr><td id=\"$sub_menu_id\" style=\"padding-top:3px;padding-bottom:3px;padding-left:10px;padding-right:10px;\" class=\"subMenuOut\" onClick=\"document.location.href='" . $page_menu_url[$i][$j] . "';\" onMouseover=\"swapMenu(this.id, 'over');\" onMouseout=\"swapMenu(this.id, 'out');\">" . $page_menu_name[$i][$j] . "</td></tr>";
			if ($main_menu_index == $temp_menu_index) {
				$page_menu_id = "page_menu_" . $temp_menu_index . "_" . ($j + 1);
				$page_menu_file = "../../images/menu/$page_menu_id.jpg";
				$page_menu_over = "../../images/menu/o_$page_menu_id.jpg";
				if (file_exists($page_menu_file) && file_exists($page_menu_over)) {
					$img_size = getimagesize($page_menu_file);
					$tpl->assign(PAGE_MENU_IMAGE, "<a href=\"" . $page_menu_url[$i][$j] . "\"><img id=\"$page_menu_id\" src=\"$page_menu_file\" width=\"$img_size[0]\" height=\"$img_size[1]\" onMouseover=\"swapMenu(this.id, 'over');\" onMouseout=\"swapMenu(this.id, 'out');\">");
					$tpl->parse(PAGE_MENU_ROWS, ".page_menu_row");
					$tpl->assign(array(PAGE_IMG_INDEX => $j,
					                   PAGE_OUT_FILE  => $page_menu_file,
					                   PAGE_OVER_FILE => $page_menu_over));
					$tpl->parse(PAGE_IMG_ROWS, ".page_img_row");
				}
			}
		}
		if ($sub_menu_list != "") {
			$tpl->assign(array(SUB_MENU_LAYER => "subMenuLayer_" . $temp_menu_index,
			                   SUB_MENU_SPACE => $sub_menu_space[$i],
			                   SUB_MENU_MAIN  => $temp_menu_index,
			                   SUB_MENU_LIST  => "<table border=\"0\" cellspacing=\"3\" cellpadding=\"0\" style=\"filter:alpha(opacity=85);\" bgcolor=\"#b5a285\"><tr><td style=\"padding-top:10px;padding-bottom:10px;padding-left:5px;padding-right:5px;\" bgcolor=\"#ffffff\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"3\">" . $sub_menu_list . "</table></td></tr></table>"));
			$tpl->parse(SUB_MENU_ROWS, ".sub_menu_row");
		}
	}
	// 부가메뉴 구성
	for ($i = 0; $i < $etc_menu_count; $i++) {
		$etc_menu_id = "etc_menu_" . ($i + 1);
		$etc_menu_file = "../../images/menu/$etc_menu_id.jpg";
		$etc_menu_over = "../../images/menu/o_$etc_menu_id.jpg";
		if (file_exists($etc_menu_file) && file_exists($etc_menu_over)) {
			$img_size = getimagesize($etc_menu_file);
			$tpl->assign(ETC_MENU_IMAGE, "<a href=\"" . $etc_menu_url[$i] . "\"><img id=\"$etc_menu_id\" src=\"$etc_menu_file\" width=\"$img_size[0]\" height=\"$img_size[1]\" onMouseover=\"swapMenu(this.id, 'over');\" onMouseout=\"swapMenu(this.id, 'out');\"></a>");
			$tpl->parse(ETC_MENU_ROWS, ".etc_menu_row");
			$tpl->assign(array(ETC_IMG_INDEX => $i,
			                   ETC_OUT_FILE  => $etc_menu_file,
			                   ETC_OVER_FILE => $etc_menu_over));
			$tpl->parse(ETC_IMG_ROWS, ".etc_img_row");
		}
	}
	// 하단메뉴 구성
	for ($i = 0; $i < $footer_menu_count; $i++) {
		$footer_menu_id = "footer_menu_" . ($i + 1);
		$footer_menu_file = "../../images/menu/$footer_menu_id.jpg";
		$footer_menu_over = "../../images/menu/o_$footer_menu_id.jpg";
		if (file_exists($footer_menu_file) && file_exists($footer_menu_over)) {
			$img_size = getimagesize($footer_menu_file);
			$tpl->assign(FOOTER_MENU_IMAGE, "<a href=\"" . $footer_menu_url[$i] . "\"><img id=\"$footer_menu_id\" src=\"$footer_menu_file\" width=\"$img_size[0]\" height=\"$img_size[1]\" onMouseover=\"this.src=footerMenuOver[$i].src;\" onMouseout=\"this.src=footerMenuOut[$i].src;\"></a>");
			$tpl->parse(FOOTER_MENU_ROWS, ".footer_menu_row");
			$tpl->assign(array(FOOTER_IMG_INDEX => $i,
			                   FOOTER_OUT_FILE  => $footer_menu_file,
			                   FOOTER_OVER_FILE => $footer_menu_over));
			$tpl->parse(FOOTER_IMG_ROWS, ".footer_img_row");
		}
	}
	// 페이지 이미지 구성
	$page_img = "";
	if ($main_menu_index > 0) $page_img = "../../images/main/sub_img_" . $main_menu_index . ".jpg";
	else $page_img = "../../images/main/sub_img_0.jpg";
	if (file_exists($page_img)) {
		$img_size = getimagesize($page_img);
		$page_img = "<img src=\"$page_img\" width=\"$img_size[0]\" height=\"$img_size[1]\">";
	}
	// 페이지 타이틀 구성
	$page_title_file = "";
	if ($main_menu_index > 0) $page_title_file = "../../images/title/page_title_" . $main_menu_index . "_" . $page_menu_index . ".jpg";
	else if ($etc_menu_index > 1) $page_title_file = "../../images/title/page_title_0_" . $etc_menu_index . ".jpg";
	else if (trim($code) != "") $page_title_file = "../../images/title/page_title_" . trim($code) . ".jpg";
	else $page_title = "";
	if (file_exists($page_title_file)) {
		$img_size = getimagesize($page_title_file);
		$page_title = "<img src=\"$page_title_file\" width=\"$img_size[0]\" height=\"$img_size[1]\">";
	}
	$page_title1_file = "";
	if ($main_menu_index > 0) $page_title1_file = "../../images/title/page_title1_" . $main_menu_index . ".jpg";
	else $page_title1_file = "../../images/title/page_title1_0.jpg";
	if (file_exists($page_title1_file)) {
		$img_size = getimagesize($page_title1_file);
		$page_title1 = "<img src=\"$page_title1_file\" width=\"$img_size[0]\" height=\"$img_size[1]\">";
	}
	// 페이지 메뉴타이틀 구성
	$menu_title_file = "";
	if ($main_menu_index > 0) {
		$menu_title_file = "../../images/title/menu_title_" . $main_menu_index . ".jpg";
		if (file_exists($menu_title_file)) {
			$img_size = getimagesize($menu_title_file);
			$menu_title = "<img src=\"$menu_title_file\" width=\"$img_size[0]\" height=\"$img_size[1]\">";
		}
	} else $menu_title = "&nbsp;";

	if ($main_menu_index > 0 && $page_menu_count < 1) $page_menu_count = $sub_menu_count[$main_menu_index - 1];
	if (substr($code, 0, 5) === "grad_") $page_logo = "../../images/main/logo_graduate.jpg";
	else $page_logo = "../../images/main/logo.jpg";
	$tpl->assign(array(MAIN_MENU_INDEX   => $main_menu_index,
	                   PAGE_MENU_INDEX   => $page_menu_index,
	                   ETC_MENU_INDEX    => $etc_menu_index,
	                   MAIN_MENU_COUNT   => $main_menu_count,
	                   PAGE_MENU_COUNT   => $page_menu_count,
	                   ETC_MENU_COUNT    => $etc_menu_count,
	                   FOOTER_MENU_COUNT => $footer_menu_count,
	                   SUB_MENU_COUNT    => $arr_sub_menu_count,
	                   PAGE_ONLOAD       => $on_load,
	                   PAGE_IMAGE        => $page_img,
	                   PAGE_TITLE        => $page_title,
	                   PAGE_TITLE1       => $page_title1,
	                   MENU_TITLE        => $menu_title,
	                   HOME_URL          => $etc_menu_url[0],
	                   PAGE_CONTENT      => $body,
	                   PAGE_LOGO         => $page_logo));

	$tpl->parse(FINAL, "main");
	$tpl->FastPrint(FINAL);
?>