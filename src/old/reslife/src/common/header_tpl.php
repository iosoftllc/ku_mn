<?
	include_once("../../lib/class.rFastTemplate.php");  

	$mainmenu_name = array("관리자관리","학생동관리","교수동관리","대학원생관리","게시판관리","통계관리","개인정보처리");
	$mainmenu_left = array("70","10","300","300","500","730","815");
	$mainmenu_width = array("220","900","500","500","350","60","200");

	$submenu_name[0] = array("관리자관리","메일보내기","발송메일함");
	$submenu_name[1] = array("지원자관리","온라인지원관리","일반지원관리","어학당지원관리","과납금관리","납부연기관리","룸배정현황","호실관리","[OLD]룸배정현황","[OLD]호실관리");
	$submenu_name[2] = array("객실예약관리","시설예약관리","교원동예약현황","교수동사실배정현황","회의실예약현황");
	$submenu_name[3] = array("지원자관리","온라인지원관리","과납금관리","사실배정현황","호실관리");
	$submenu_name[4] = array("스팸관리","환경설정","News & Notice","Flea Market");
	$submenu_name[5] = array("접속통계");
	$submenu_name[6] = array("접속내역","업무내역");

	$submenu_url[0] = array("https://reslife.korea.ac.kr:5008/admin/src/mail/list.php","https://reslife.korea.ac.kr:5008/admin/src/mail/mail.php","https://reslife.korea.ac.kr:5008/admin/src/mail/mailbox.php");
	$submenu_url[1] = array("https://reslife.korea.ac.kr:5008/admin/src/apply/stu_list.php","https://reslife.korea.ac.kr:5008/admin/src/apply/app_list.php","https://reslife.korea.ac.kr:5008/admin/src/apply/list.php?s_kind=U","https://reslife.korea.ac.kr:5008/admin/src/apply/list.php?s_kind=L","https://reslife.korea.ac.kr:5008/admin/src/apply/re_list.php","https://reslife.korea.ac.kr:5008/admin/src/apply/defer_list.php","https://reslife.korea.ac.kr:5008/admin/src/apply/app_calendar.php","https://reslife.korea.ac.kr:5008/admin/src/apply/room_list.php","https://reslife.korea.ac.kr:5008/admin/src/apply/app_calendar_old.php","https://reslife.korea.ac.kr:5008/admin/src/apply/room_old_list.php");
	$submenu_url[2] = array("https://reslife.korea.ac.kr:5008/admin/src/faculty/room_list.php","https://reslife.korea.ac.kr:5008/admin/src/faculty/fac_list.php","https://reslife.korea.ac.kr:5008/admin/src/faculty/room_calendar.php?kind=1","https://reslife.korea.ac.kr:5008/admin/src/faculty/room_calendar.php?kind=2","https://reslife.korea.ac.kr:5008/admin/src/faculty/fac_calendar.php");
	$submenu_url[3] = array("https://reslife.korea.ac.kr:5008/admin/src/graduate/stu_list.php","https://reslife.korea.ac.kr:5008/admin/src/graduate/app_list.php","https://reslife.korea.ac.kr:5008/admin/src/graduate/re_list.php","https://reslife.korea.ac.kr:5008/admin/src/graduate/app_calendar.php","https://reslife.korea.ac.kr:5008/admin/src/graduate/room_list.php");
	$submenu_url[4] = array("https://reslife.korea.ac.kr:5008/admin/src/board/spam.php","https://reslife.korea.ac.kr:5008/admin/src/board/setting.php","https://reslife.korea.ac.kr:5008/admin/src/board/list.php?type=1","https://reslife.korea.ac.kr:5008/admin/src/board/list.php?type=2");
	$submenu_url[5] = array("https://reslife.korea.ac.kr:5008/admin/src/stat/counter.php");
	$submenu_url[6] = array("../../src/log/access_list.php","../../src/log/work_list.php");

	if ($html_dir == "stat") {
		$tpl = new rFastTemplate("../../tpl/$html_dir");
		$tpl->define(array(stat_menu    => "ct_menu.html",
		                   stat_submenu => $submenu,
		                   stat_result  => $result,
		                   body         => "stat_main.html"));
	} else {
		if (!file_exists("../../tpl/$html_dir/$html_file.html")) $html_file = "../main/not_found";
		$tpl = new rFastTemplate("../../tpl/$html_dir");
		$tpl->define(array(body => "$html_file.html"));
	}
?>