<?
	include_once("../../lib/conf.common.php");
	include_once("../../lib/class.rFastTemplate.php");

	$url_page = "https://reslife.korea.ac.kr:5008/v1/src/main/page.php?code=";
	$url_board = "https://reslife.korea.ac.kr:5008/v1/src/board/list.php";

	// 메인메뉴, 서브메뉴, 부가메뉴의 이름 및 연결주소, 개수 설정
	$sub_menu_space = array(15,200,0,535,735,0);
	$main_menu_name = array("Undergraduate Students","Faculty & Staff Residence","Seminar & Conference","Graduate School Student","Contact","Photo Gallery");
	$main_menu_url = array($url_page."intro",$url_page."intro_f",$url_page."facility",$url_page."grad_intro",$url_page."contact",$url_page."gallery");
	$page_menu_name[0] = array("Residence Hall","Residence Type & Rates","Important Dates","Application Procedure","Residence Hall Contract","Eligibility & Assignment Priority","Check-in & Check-out","Overpayment Refund Request & Carry Forward Request","My Housing Account",/*"Flea Market",*/"FAQ");
	$page_menu_url[0] = array($url_page."intro",$url_page."rate",$url_page."important",$url_page."procedure_stu",$url_page."contract",$url_page."assign",$url_page."check",$url_page."refund",$url_page."status_stu",/*$url_board,*/$url_page."faq_under");
	$page_menu_name[1] = array("Residence Hall","Room Type & Rates","Application Procedure","국제교원기숙사사용안내","Move in & Out Policies","Rules & Regulations","FAQ");
	$page_menu_url[1] = array($url_page."intro_f",$url_page."rate_f",$url_page."procedure_fe",$url_page."procedure_fk",$url_page."contract_f1",$url_page."contract_f2",$url_page."faq");
	$page_menu_name[2] = array();
	$page_menu_url[2] = array();
	$page_menu_name[3] = array("Graduate School Student (대학원생 기숙사)","Dormitory Type & Rates (기숙사 방 유형 & 가격)","Important Dates (기숙사 주요 날짜)","Application Procedure (지원절차)","Dormitory Contract (기숙사 약관)","Criteria for Penalty Points (안암학사 사생수칙)","Eligibility & Assignment Priority (선발 우선 순위)","Check in & Check out (입실 및 퇴실 절차)","Dormitory Payment & Refund Policy (기숙사비 납부 및 환불안내)","My Housing Account (나의 기숙사 계정)");
	$page_menu_url[3] = array($url_page."grad_intro",$url_page."grad_rate",$url_page."grad_important",$url_page."grad_procedure",$url_page."grad_contract",$url_page."grad_criteria",$url_page."grad_assign",$url_page."grad_check",$url_page."grad_payment",$url_page."grad_account");
	$page_menu_name[4] = array("Contact","Map","Direction");
	$page_menu_url[4] = array($url_page."contact",$url_page."map",$url_page."direction");
	$page_menu_name[5] = array();
	$page_menu_url[5] = array();
	$etc_menu_name = array("Home","Contact","Sitemap","Privacy Policy Statement");
	$etc_menu_url = array("../../",$url_page."contact",$url_page."sitemap",$url_page."privacy");
	$footer_menu_name = array("Home","Contact","Sitemap","Privacy Policy Statement");
	$footer_menu_url = array("../../",$url_page."contact",$url_page."sitemap",$url_page."privacy");

	// 메뉴 개수 설정
	$arr_sub_menu_count = "";
	$main_menu_count = count($main_menu_name);
	for ($i = 0; $i < $main_menu_count; $i++) {
		$sub_menu_count[$i] = count($page_menu_name[$i]);
		$arr_sub_menu_count .= $sub_menu_count[$i] . ",";
	}
	if ($arr_sub_menu_count != "") $arr_sub_menu_count = substr($arr_sub_menu_count, 0, -1);
	$page_menu_count = 0;
	$etc_menu_count = count($etc_menu_name);
	$footer_menu_count = count($footer_menu_name);
	// 메뉴값 설정
	if (!is_numeric($main_menu_index)) $main_menu_index = 0;
	if ($main_menu_index < 0 || $main_menu_index > $main_menu_count) $main_menu_index = 0;
	if ($main_menu_index > 0) {
		$etc_menu_index = 0;
		if (!is_numeric($page_menu_index)) $page_menu_index = 1;
		if ($page_menu_index < 0 || $page_menu_index > count($page_menu_url[$main_menu_index - 1])) $page_menu_index = 1;
		else $page_menu_count = count($page_menu_url[$main_menu_index - 1]);
	} else {
		$page_menu_index = 0;
		if (!is_numeric($etc_menu_index)) $etc_menu_index = 0;
		if ($etc_menu_index < 0 || $etc_menu_index > $etc_menu_count) $etc_menu_index = 0;
	}

	if (!file_exists("../../tpl/$html_dir/$html_file.html")) $html_file = "../main/not_found";
	$tpl = new rFastTemplate("../../tpl/$html_dir");
	$tpl->define(array(body => "$html_file.html"));
?>